<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Payment;
use App\Models\TransactionTemp;
use App\Models\Dropdown;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function index(){
        //dd('transaction menu');
        $transaction = TransactionHeader::
        leftJoin('users', 'users.id', '=', 'transaction_headers.id_user')
        ->select(
            'transaction_headers.*',
            'users.name as user_name'
            )
        ->get();
        // dd($transaction);
        return view('transaction.index',compact('transaction'));
    }

    public function detail($id){
        $id = decrypt($id);
        $detail = TransactionDetail::
        where('transaction_header_id',$id)
        ->leftJoin('ticket_categories', 'ticket_categories.id', '=', 'transaction_details.id_ticket_category')
        ->leftJoin('events', 'events.id', '=', 'transaction_details.id_event')
        ->leftJoin('showtimes', 'showtimes.id', '=', 'transaction_details.id_showtime')
        ->select(
            'transaction_details.*',
            'ticket_categories.category',
            'events.event_name',
            'showtimes.showtime_start',
            'showtimes.showtime_finish',
            )
        ->get();
        return view('transaction.detail',compact('detail'));
    }

    public function payment($id){
        $id = decrypt($id);
        $payment = Payment::where('id_transaction_header',$id)
        ->leftJoin('transaction_headers', 'transaction_headers.id', '=', 'payments.id_transaction_header')
        ->select(
            'transaction_headers.*',
            'payments.id as payment_id',
            'payments.id_transaction_header',
            'payments.payment_file',
            'payments.status as payment_status',
            'payments.closed_by',
            'payments.closed_date',
            'payments.payment_method',
            )
        ->get();
        //dd(base64_decode($payment->payment_file));
        return view('transaction.payment',compact('payment'));
    }

    public function acceptPayment(Request $request,$id)
    {
        //dd($request->id_transaction_header);
        //$id = decrypt($id);
        $created_date=Carbon::now();
        $created_by=auth()->user()->name;

        DB::beginTransaction();
        try {

            $acceptTicketPayment = Payment::where('id', $id)->update([
                'status' => '4',
                'closed_by' => $created_by,
                'closed_date' => $created_date
            ]);

            $acceptTicketPaymentHeader = TransactionHeader::where('id', $request->id_transaction_header)->update([
                'status' => '4',
                'notes' => $request->notes,
            ]);

            DB::commit();
            // all good
            $id = encrypt($id);
            return redirect('/transaction/payment/'. $id)->with('status', 'Success Accept Ticket Payment');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id = encrypt($id);
            return redirect('/transaction/payment/'. $id)->with('failed', 'Failed Accept Ticket Payment');
        }
    }
    public function refundPayment(Request $request,$id)
    {
        //dd($request);
        $created_date=Carbon::now();
        $created_by=auth()->user()->name;

        DB::beginTransaction();
        try {

            $acceptTicketPayment = Payment::where('id', $id)->update([
                'status' => '2',
                'closed_by' => $created_by,
                'closed_date' => $created_date
            ]);

            $acceptTicketPaymentHeader = TransactionHeader::where('id', $request->id_transaction_header)->update([
                'status' => '2',
                'notes' => $request->notes,
            ]);
            $query = TransactionHeader::where('id', $request->id_transaction_header);
            $getArrayID = $query->pluck('id')->toArray();
            $getArrayDetail = TransactionDetail::where('transaction_header_id', $request->id_transaction_header)
            ->select('*')
            ->get()->toArray();
            //dd($getArrayDetail);
            if (!empty($getArrayID)) {

                // perulangan update array
                foreach ($getArrayDetail as $detail) {
                    //dd($detail);
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

            DB::commit();
            // all good
            $id = encrypt($id);
            return redirect('/transaction/payment/'. $id)->with('status', 'Success Accept Ticket Payment');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
            $id = encrypt($id);
            return redirect('/transaction/payment/'. $id)->with('failed', 'Failed Accept Ticket Payment');
        }
    }
}
