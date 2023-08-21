<?php

namespace App\Console\Commands;

use App\Models\Rule;
use App\Models\Showtime;
use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;

class DeleteChart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteChart:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Max Checkout Hour
        $max_checkout = Rule::where('rule_name', 'Max Checkout')->first()->rule_value;
        $hour = Carbon::now()->subHours();

        $query = TransactionHeader::where('status', 0)  //general query
            ->where('created_at', '<=', $hour);

        $getArrayID = $query->pluck('id')->toArray(); //get id TransactionHeader dalam bentuk array dari general query
        // dd($getArrayID);
        $getArrayDetail = TransactionDetail::where('transaction_header_id', $getArrayID) //get atribut untuk update showtime
            ->select('id_ticket_category', 'id_event', 'id_showtime')
            ->get()->toArray();

        // dd($getArrayID, $getArrayDetail);

        if (!empty($getArrayID)) {
            TransactionHeader::whereIn('id', $getArrayID) //update status TransactionHeader menjadi 3 (canceled)
                ->update(['status' => 3]);

            // perulangan update array
            foreach ($getArrayDetail as $detail) {
                $idTicketCategory = $detail['id_ticket_category'];
                $idEvent = $detail['id_event'];
                $idShowtime = $detail['id_showtime'];

                // update tabel showtime qty bertambah 1 setiap kondisi terpenuhi
                Showtime::where('id_category', $idTicketCategory)
                    ->where('id_event', $idEvent)
                    ->where('id', $idShowtime)
                    ->increment('qty', 1);
            }
        }
    }
}
