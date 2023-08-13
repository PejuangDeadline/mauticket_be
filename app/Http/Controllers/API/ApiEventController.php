<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
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
}
