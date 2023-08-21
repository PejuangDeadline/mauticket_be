<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Models\Event;
use App\Models\Showtime;
use App\Models\TicketCategory;
use App\Models\TicketPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiEventController extends ApiBaseController
{
    public function eventSearch(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'until' => 'required_with:from',
            'from' => 'required_with:until',
            'limit' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if ($request->from == '' || $request->until == '') {
            $now = Carbon::now()->startOfMonth();
            $date_now = Carbon::now()->lastOfMonth();
        } else {
            $now = $request->from;
            $date_now = $request->until;
        }

        $query = DB::table('events')
        ->leftJoinSub(function ($query) {
            $query->select('*')
                ->from('showtimes')
                ->orderBy('id', 'asc');
        }, 'showtimes', function ($join) {  
            $join->on('events.id', '=', 'showtimes.id_event');
        })
        ->leftJoinSub(
            DB::table('ticket_categories')->groupBy('id_event'),
            'ticket_categories',
            function ($join) {
                $join->on('events.id', '=', 'ticket_categories.id_event');
            }
        )
        ->select('events.*', 'showtimes.showtime_start', 'ticket_categories.price')
        ->whereNotNull('showtimes.showtime_start')
        ->whereBetween(DB::raw("(STR_TO_DATE(showtime_start,'%Y-%m-%d'))"), [$now, $date_now])
        ->where('events.event_name', 'LIKE', '%'.$request->event_name.'%')
        ->where('events.city', 'LIKE', '%'.$request->city.'%')
        ->where('events.is_active', '1')
        ->groupBy('events.id')
        ->orderBy('events.id','desc');

        if($request->limit > 0){
            $query = $query->take($request->limit)->get();
        }
        else{
            $query = $query->get();
        }
        // dd($query);

        return $this->sendResponse($query, 'Success Inquiry Event.');
    }

    public function getByEvent($id_event){
        // dd($id_event);

        //cek event exist
        $checkEvent = Event::where('id',$id_event)->count();

        if($checkEvent > 0){
            //query event
            $events = Event::where('events.id',$id_event)
                ->select('mst_partners.partner_name','events.*', 'showtimes.showtime_start')
                ->leftJoinSub(function ($query) {
                    $query->select('*')
                        ->from('showtimes')
                        ->orderBy('id', 'asc');
                }, 'showtimes', function ($join) {  
                    $join->on('events.id', '=', 'showtimes.id_event');
                }) 
                ->leftJoin('mst_partners','events.id_partner', 'mst_partners.id')
                ->groupBy('events.id')
                ->get();

            $categories = TicketCategory::where('id_event',$id_event)
                ->leftJoin('events','events.id', 'ticket_categories.id_event')
                ->get();

            $showtimes = Showtime::where('id_event',$id_event)
                ->select('showtime_start','showtime_finish','id_event')
                ->leftJoin('events','events.id', 'showtimes.id_event')
                ->groupBy('showtime_start')
                ->get();

            $methodPayments = TicketPayment::where('id_event',$id_event)->get();

            $data['events'] = $events;
            $data['categories'] = $categories;
            $data['showtimes'] = $showtimes;
            $data['payment_method'] = $methodPayments;

            return $this->sendResponse($data, 'Success Inquiry Event.');
        }
        else{
            return $this->sendError('Data Not Found.', 'Event Data Not Found');
        }
    }

    public function getByShowtime(Request $request){
        // dd($id_event);
        $validator = Validator::make($request->all(), [
            'id_event' => 'required',
            'showtime' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //cek showtime exist
        $checkShowtime = Showtime::where('showtimes.id_event', $request->id_event)
            ->where('showtimes.showtime_start', $request->showtime)
            ->count();

        if($checkShowtime > 0){
            $showtimes = Showtime::select('showtimes.*', 'ticket_categories.category', 'ticket_categories.price')
                ->leftJoin('ticket_categories', 'showtimes.id_category', '=', 'ticket_categories.id')
                ->where('showtimes.id_event', $request->id_event)
                ->where('showtimes.showtime_start', $request->showtime)
                ->get();

            $data['showtimes'] = $showtimes;

            return $this->sendResponse($data, 'Success Inquiry Showtime.');
        }
        else{
            return $this->sendError('Data Not Found.', 'Showtime Data Not Found');
        }
    }

    public function getByCategory($id_category){
        // dd($id_event);

        //cek category exist
        $checkCategory = TicketCategory::where('id',$id_category)->count();

        if($checkCategory > 0){
            $categories = TicketCategory::where('ticket_categories.id',$id_category)
                ->leftJoin('events','events.id', 'ticket_categories.id_event')
                ->get();
            
            $showtimes = Showtime::where('id_category',$id_category)
                ->leftJoin('events','events.id', 'showtimes.id_event')
                ->get();

            $data['categories'] = $categories;
            $data['showtimes'] = $showtimes;

            return $this->sendResponse($data, 'Success Inquiry Category.');
        }
        else{
            return $this->sendError('Data Not Found.', 'Category     Data Not Found');
        }
    }
}
