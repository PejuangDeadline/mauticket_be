<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Event;

class ShowtimeController extends Controller
{
    public function index($id){
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        $event = Event::where('id',$id)
        ->first();
        $showTime = Showtime::where('id_event',$id)->get();
        return view('show-time.index',compact('showTime','id','event'));
    }
    public function store(Request $request, $id){    
        dd($request);
        $id = decrypt($id);
       $showTime = Showtime::where('id_event',$id)->get();
        return view('show-time.index',compact('showTime'));
    }

    public function edit(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
       $showTime = Showtime::where('id_event',$id)->get();
        return view('ticket.index',compact('showTime'));
    }

    public function destroy(Request $request,$id){  
        dd($request);  
        $id = decrypt($id);
       $showTime = Showtime::where('id_event',$id)->get();
        return view('ticket.index',compact('showTime'));
    }
}
