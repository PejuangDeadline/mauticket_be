<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketPayment;
use App\Models\Event;
use App\Models\Dropdown;

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
    public function store(Request $request, $id){    
        dd($request);
        $id = decrypt($id);
       $ticketPayment = TicketPayment::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketPayment'));
    }

    public function edit(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
       $ticketPayment = TicketPayment::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketPayment'));
    }

    public function destroy(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
       $ticketPayment = TicketPayment::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketPayment'));
    }
}
