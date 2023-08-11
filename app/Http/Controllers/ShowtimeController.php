<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class ShowtimeController extends Controller
{
    public function index($id)
    {
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        $event = Event::where('id', $id)->first();
        // dd($id, $event);
        $showTime = Showtime::select('*', 'showtimes.id as id_st', 'showtimes.is_active as isActiveSt')
        ->where('showtimes.id_event', $id)
        ->leftJoin(
            'ticket_categories',
            'ticket_categories.id',
            '=',
            'showtimes.id_category'
        )
        ->where('showtimes.is_active', 1)
        ->orderby('showtimes.id_category')
        ->get();
        // dd($showTime);
        $id_en = encrypt($id);
        return view('show-time.index', compact('showTime', 'id', 'id_en',
            'event'
        ));
    }

    public function store(Request $request, $id, $idCategory)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            "showtime_start" => "required|date_format:Y-m-d\TH:i|after_or_equal:today",
            "showtime_finish" => "required|date_format:Y-m-d\TH:i|after:showtime_start|ends_after_start:showtime_start",
        ]);

        if ($validator->fails()) {
            $id_en = encrypt($id);
            return redirect('/show-time/' . $id_en)->withErrors($validator)->withInput();
        }
        
        DB::beginTransaction();
        try {

            // validasi db existingShowtime
            $showtimeStart = $request->showtime_start;
            $showtimeFinish = $request->showtime_finish;

            $existingShowtime = Showtime::where('id_event', $id)
                ->where('is_active', 1)
                ->where(function ($query) use ($showtimeStart, $showtimeFinish) {
                $query->where(function ($q) use ($showtimeStart, $showtimeFinish) {
                    $q->where(function ($subQ) use ($showtimeStart, $showtimeFinish) {
                        $subQ->where('showtime_start', '>=', $showtimeStart)
                            ->where('showtime_start', '<=', $showtimeFinish);
                    })
                        ->orWhere(function ($subQ) use ($showtimeStart, $showtimeFinish) {
                            $subQ->where('showtime_finish', '>=', $showtimeStart)
                                ->where('showtime_finish', '<=', $showtimeFinish);
                        });
                })
                    ->orWhere(function ($q) use ($showtimeStart, $showtimeFinish) {
                            $q->where('showtime_start', '<=', $showtimeStart)
                                ->where('showtime_finish', '>=', $showtimeStart);
                        });
                })
                ->first();
            
            // dd($existingShowtime);
            if ($existingShowtime) {
                $id_en = encrypt($id);
                return redirect('/show-time/' . $id_en)->with('failed', 'Showtime range must be unique for this event !');
            } else {

                Showtime::create([
                    'id_event' => $id,
                    'id_category' => $idCategory,
                    'showtime_start' => $request->showtime_start,
                    'showtime_finish' => $request->showtime_finish,
                    'qty' => $request->qty,
                    'is_active' => '1',
                ]);
            }

            DB::commit();
            // all good
            $id_en = encrypt($id);
            return redirect('/show-time/' . $id_en)->with('status', 'Success Create Show Time');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong
            $id_en = encrypt($id);
            return redirect('/show-time/' . $id_en)->with('failed', 'Failed Create Show Time');
        }
    }

    public function edit(Request $request, $idEvent, $id)
    {
        // dd($id, $request);
        $validator = Validator::make($request->all(), [
            "showtime_start" => "required|date_format:Y-m-d\TH:i",
            "showtime_finish" => "required|date_format:Y-m-d\TH:i|after:showtime_start|ends_after_start:showtime_start",
            "qty" => "required"
        ]);

        if ($validator->fails()) {
            // Tangani jika validasi gagal
            $idEvent_en = encrypt($idEvent);
            return redirect('/show-time/' . $idEvent_en)->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            Showtime::where('id', $id)
                ->update([
                    'showtime_start' => $request->showtime_start,
                    'showtime_finish' => $request->showtime_finish,
                    'qty' => $request->qty,
                    'is_active' => '1',
                ]);

            DB::commit();
            // all good
            $idEvent_en = encrypt($idEvent);

            return redirect('/show-time/' . $idEvent_en)->with('status', 'Success Update Show Time');
        } catch (\Exception $e) {
            DB::rollback();
            // dd($e);
            // something went wrong
            $idEvent_en = encrypt($idEvent);
            return redirect('/show-time/' . $idEvent_en)->with('failed', 'Failed Update Show Time');
        }
    }

    public function destroy($idEvent, $id)
    {
        DB::beginTransaction();
        try {

            Showtime::where('id', $id)
                ->update([
                    'is_active' => '0'
                ]);
            // $deleteShowTime = Showtime::where('id', $id)->delete();

            DB::commit();
            // all good
            $idEvent_en = encrypt($idEvent);
            return redirect('/show-time/' . $idEvent_en)->with('status', 'Success Delete Show Time');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // something went wrong
            $idEvent_en = encrypt($idEvent);
            return redirect('/show-time/' . $idEvent_en)->with('failed', 'Failed Delete Show Time');
        }
    }
}
