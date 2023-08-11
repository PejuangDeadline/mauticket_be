<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TicketCategory;
use App\Models\Event;

class TicketCategoryController extends Controller
{
    public function index($id){
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        //dd($id);
        $event = Event::where('id',$id)
        ->first();
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        // dd($ticketCategory);
        return view('ticket.index',compact('ticketCategory','id','event'));
    }

    public function store(Request $request, $id){
        //$id = decrypt($id);
        //$ticketCategory = TicketCategory::where('id_event',$id)->get();
        //dd($id);
        // create by email
        $created_by = auth()->user()->email;
        // convert price value
        $price = str_replace(',','',$request->price);
        //dd($price);
        DB::beginTransaction();
        try {

            $query =  TicketCategory::create([
                        'id_event' => $request->id_event,
                        'category' => $request->category,
                        'inc_seat' => $request->inc_seat,
                        'price' => $price,
                        //'created_by' => $created_by,
                    ]);
            DB::commit();
            // all good
            $id_en = encrypt($id);

            return redirect('/ticket-category/'.$id_en)->with('status','Success Create Ticket Category');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_en = encrypt($id);

            return redirect('/ticket-category/'.$id_en)->with('failed','Failed Create Ticket Category');
        }
    }

    public function edit(Request $request,$id){
        dd($request);
        //dd($request->id_event);
        // $id = decrypt($id);
        // $ticketCategory = TicketCategory::where('id_event',$id)->get();
        // return view('ticket.index',compact('ticketCategory'));
        $id_event = $request->id_event;
        $id_ticket_category = $request->id;
        $ticket_category = TicketCategory::where('id',$id_ticket_category)->first();

        // convert price value
        $price = str_replace(',','',$request->price);

        // compare data with database
        $ticket_category->category = $request->category;
        $ticket_category->inc_seat = $request->inc_seat;
        $ticket_category->price = $request->price;

        $created_by = auth()->user()->email;
        DB::beginTransaction();
        try {
            if($ticket_category->isDirty())
            {
                //dd('berubah');
                $query =  TicketCategory::where('id',$id)
                ->update([
                    'category' => $request->category,
                    'inc_seat' => $request->inc_seat,
                    'price' => $price,
                ]);
            }
            else
            {
                //dd('tidak berubah');
            }
            DB::commit();
            // all good
            $id_en = encrypt($id_event);

            return redirect('/ticket-category/'.$id_en)->with('status','Success Update Ticket Category');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_en = encrypt($id_event);

            return redirect('/ticket-category/'.$id_en)->with('failed','Failed Update Ticket Category');
        }

    }

    public function destroy(Request $request,$id){
        //dd($id);

        // $id = decrypt($id);
        // $ticketCategory = TicketCategory::where('id_event',$id)->get();
        // dd('destroy');
        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  TicketCategory::where('id',$id)->delete();
            DB::commit();
            // all good
            $id_en = encrypt($request->id_event);

            return redirect('/ticket-category/'.$id_en)->with('status','Success Delete Ticket Category');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_en = encrypt($request->id_event);

            return redirect('/ticket-category/'.$id_en)->with('failed','Failed Delete Ticket Category');
        }
    }
}
