<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketCategory;
use App\Models\Event;

class TicketCategoryController extends Controller
{
    public function index($id){    
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        $event = Event::where('id',$id)
        ->first();
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketCategory','id','event'));
    }

    public function store(Request $request, $id){    
        dd($request);
        $id = decrypt($id);
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketCategory'));
    }

    public function edit(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketCategory'));
    }

    public function destroy(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        return view('ticket.index',compact('ticketCategory'));
    }
}
