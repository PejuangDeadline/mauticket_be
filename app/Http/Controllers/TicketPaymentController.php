<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Models\TicketPayment;
use Illuminate\Support\Facades\DB;

class TicketPaymentController extends Controller
{
    public function index($id){
        $id = decrypt($id);
        $event = Event::where('id',$id)
        ->first();
        $ticketPayment = TicketPayment::where('id_event',$id)->get();
        $dropdownPaymentMethod = Dropdown::where('category','Payment Method')->get();
        $dropdownBankTransfer = Dropdown::where('category','Bank Transfer')->get();
        return view('ticket.indexPayment',compact('ticketPayment','id','event','dropdownPaymentMethod','dropdownBankTransfer'));
    }
    public function store(Request $request, $id)
    {
        // dd($request);
        // $id = decrypt($id);
        $created_by = auth()->user()->email;
        $request->validate([
            "payment_method" => "required",
            "bank_name" => "required",
            "account_number" => "required",
            "account_name" => "required",
        ]);

        DB::beginTransaction();
        try {

            $query = TicketPayment::create([
                'id_event' => $id,
                'payment_method' => $request->payment_method,
                'bank_name' => $request->bank_name,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'created_by' => $created_by,
            ]);


            DB::commit();
            // all good

            return redirect('/ticket-payment/' . $id)->with('status', 'Success Create Ticket Payment');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/ticket-payment/' . $id)->with('failed', 'Failed Create Ticket Payment');
        }
    }

    public function edit(Request $request, $id)
    {
        // dd($request);  
        // $id = decrypt($id);
        $ticketPayment = TicketPayment::where('id_event', $id)->first();
        dd($id, $ticketPayment);

        DB::beginTransaction();
        try {
            if ($ticketPayment->isDirty()) {
                //dd('berubah');
                $query =  TicketPayment::where('id_event', $id)
                    ->update([
                        'payment_method' => $request->payment_method,
                        'bank_name,' => $request->bank_name,
                        'account_number,' => $request->account_number,
                        'account_name,' => $request->account_name,
                    ]);
            } else {
                $query =  TicketPayment::where('id_event', $id)
                    ->update([
                        'payment_method' => $request->payment_method,
                        'bank_name,' => $request->bank_name,
                        'account_number,' => $request->account_number,
                        'account_name,' => $request->account_name,
                    ]);
                //dd('tidak berubah');
            }
            DB::commit();
            // all good

            return redirect('/ticket-payment/' . $id)->with('status', 'Success Update Ticket Payment');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect('/ticket-payment/' . $id)->with('failed', 'Failed Update Ticket Payment');
        }
    }

    public function destroy(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);

        DB::beginTransaction();
        try {

            $deleteTicketPayment = TicketPayment::where('id', $id)->delete();

            DB::commit();
            // all good

            return redirect('/show-time/' . $id)->with('status', 'Success Delete Ticket Payment');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/show-time/' . $id)->with('failed', 'Failed Delete Ticket Payment');
        }
    }
}
