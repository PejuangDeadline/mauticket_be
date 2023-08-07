<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Dropdown;
use Illuminate\Http\Request;
use App\Models\TicketPayment;
use Illuminate\Support\Facades\DB;

class TicketPaymentController extends Controller
{
    public function index($id)
    {
        $id = decrypt($id);
        $event = Event::where('id', $id)
            ->first();
        $ticketPayment = TicketPayment::where('id_event', $id)->get();
        $dropdownPaymentMethod = Dropdown::where('category', 'Payment Method')->get();
        $dropdownBankTransfer = Dropdown::where('category', 'Bank Transfer')->get();
        return view('ticket.indexPayment', compact('ticketPayment', 'id', 'event', 'dropdownPaymentMethod', 'dropdownBankTransfer'));
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
            $bank = TicketPayment::where('id_event', $id)
                ->where('bank_name', $request->bank_name)
                ->first();
            // dd($bank);

            if ($bank) {
                $id_en = encrypt($id);
                return redirect('/ticket-payment/' . $id_en)->with('failed',  'Ticket Payment Already Exist !');
            } else {
                $query = TicketPayment::create([
                    'id_event' => $id,
                    'payment_method' => $request->payment_method,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                    'created_by' => $created_by,
                ]);
            }

            DB::commit();
            // all good
            $id_en = encrypt($id);
            return redirect('/ticket-payment/' . $id_en)->with('status', 'Success Create Ticket Payment');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
            $id_en = encrypt($id);
            return redirect('/ticket-payment/' . $id_en)->with('failed', 'Failed Create Ticket Payment');
        }
    }

    public function edit(Request $request, $idEvent, $id)
    {

        $ticketPayment = TicketPayment::where('id', $id)->first();
        // dd($id, $ticketPayment);

        DB::beginTransaction();
        try {
            if ($ticketPayment->isDirty()) {
                //dd('berubah');
                $query =  TicketPayment::where('id', $id)
                    ->update([
                        'payment_method' => $request->payment_method,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                    ]);
            } else {
                $query =  TicketPayment::where('id', $id)
                    ->update([
                        'payment_method' => $request->payment_method,
                    'bank_name' => $request->bank_name,
                    'account_number' => $request->account_number,
                    'account_name' => $request->account_name,
                    ]);
                //dd('tidak berubah');
            }
            DB::commit();
            // all good
            $idEvent_en = encrypt($idEvent);
            return redirect('/ticket-payment/' . $idEvent_en)->with('status', 'Success Update Ticket Payment');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
            $idEvent_en = encrypt($idEvent);
            return redirect('/ticket-payment/' . $idEvent_en)->with('failed', 'Failed Update Ticket Payment');
        }
    }

    public function destroy($idEvent, $id)
    {
        // dd($request);
        // $id = decrypt($id);

        DB::beginTransaction();
        try {

            $deleteTicketPayment = TicketPayment::where('id', $id)->delete();

            DB::commit();
            // all good
            $idEvent_en = encrypt($idEvent);
            return redirect('/ticket-payment/' . $idEvent_en)->with('status', 'Success Delete Ticket Payment');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong
            $idEvent_en = encrypt($idEvent);
            return redirect('/ticket-payment/' . $idEvent_en)->with('failed', 'Failed Delete Ticket Payment');
        }
    }
}
