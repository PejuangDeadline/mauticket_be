<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionDetail;
use App\Models\TransactionHeader;

class TransactionController extends Controller
{
    public function index()
    {

        // Max Checkout Hour
        $max_checkout = Rule::where('rule_name', 'Max Checkout')->first()->rule_value;
        $hour = Carbon::now()->subHours($max_checkout);
        $query = TransactionHeader::where('status', 0)  //general query
            ->where('created_at', '>=', $hour);
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
            dd('berhasil update status header + kembaliin qty');
        }
    }
}
