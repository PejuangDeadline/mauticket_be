<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Models\Event;
use App\Models\Showtime;
use App\Models\TicketCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiEventController extends ApiBaseController
{
    public function eventSearch(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'until' => 'required_with:from',
            'from' => 'required_with:until',
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
                ->orderBy('id', 'asc')
                ->limit(1);
        }, 'showtimes', function ($join) {
            $join->on('events.id', '=', 'showtimes.id_event');
        })
        ->select('events.*', 'showtimes.showtime_start')
        ->whereNotNull('showtimes.showtime_start')
        ->whereBetween(DB::raw("(STR_TO_DATE(showtime_start,'%Y-%m-%d'))"), [$now, $date_now])
        ->where('events.event_name', 'LIKE', '%'.$request->event_name.'%')
        ->where('events.city', 'LIKE', '%'.$request->city.'%')
        ->get();
        // dd($query);

        return $this->sendResponse($query, 'Success Inquiry Event.');
    }

    public function getByEvent($id_event){
        // dd($id_event);

        //cek event exist
        $checkEvent = Event::where('id',$id_event)->count();

        if($checkEvent > 0){
            //query event
            $events = Event::where('id',$id_event)->get();

            $categories = TicketCategory::where('id_event',$id_event)
                ->leftJoin('events','events.id', 'ticket_categories.id_event')
                ->get();

            $showtimes = Showtime::where('id_event',$id_event)
                ->leftJoin('events','events.id', 'showtimes.id_event')
                ->get();

            $data['events'] = $events;
            $data['categories'] = $categories;
            $data['showtimes'] = $showtimes;

            return $this->sendResponse($data, 'Success Inquiry Event.');
        }
        else{
            return $this->sendError('Data Not Found.', 'Event Data Not Found');
        }
    }

    public function getByShowtime($id_showtime){
        // dd($id_event);

        //cek showtime exist
        $checkShowtime = Showtime::where('id',$id_showtime)->count();

        if($checkShowtime > 0){
            $showtimes = Showtime::where('showtimes.id',$id_showtime)
                ->leftJoin('events','events.id', 'showtimes.id_event')
                ->leftJoin('ticket_categories','ticket_categories.id', 'showtimes.id_category')
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
