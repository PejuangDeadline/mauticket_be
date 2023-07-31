<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketPayment;

class TicketPaymentController extends Controller
{
    public function index($id){
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        $ticketPayment = TicketPayment::where('id_event',$id)->get();
        return view('ticket.indexPayment',compact('ticketPayment','id'));
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
