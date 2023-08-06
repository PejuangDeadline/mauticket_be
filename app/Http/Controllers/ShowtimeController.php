<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ShowtimeController extends Controller
{
    public function index($id)
    {
        //need Query for eventName in scheme event->event_name
        $id = decrypt($id);
        // dd('test');
        $event = Event::where('id', $id)->first();
        $showTime = Showtime::where('id_event', $id)->get();
        return view('show-time.index', compact('showTime', 'id', 'event'));
    }

    public function store(Request $request, $id)
    {
        // dd($request);
        // $id = decrypt($id);

        $request->validate([
            "showtime_start" => "required",
            "showtime_finish" => "required"
        ]);

        DB::beginTransaction();
        try {

            $query = Showtime::create([
                'id_event' => $id,
                'showtime_start' => $request->showtime_start,
                'showtime_finish' => $request->showtime_finish
            ]);


            DB::commit();
            // all good

            return redirect('/show-time/' . $id)->with('status', 'Success Create Show Time');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/show-time/' . $id)->with('failed', 'Failed Create Show Time');
        }
    }

    public function edit(Request $request, $id)
    {
        // dd($request);
        // $id = decrypt($id);
        $showTime = Showtime::where('id_event', $id)->first();
        dd($id, $showTime);

        DB::beginTransaction();
        try {
            if ($showTime->isDirty()) {
                //dd('berubah');
                $query =  Showtime::where('id_event', $id)
                    ->update([
                        'showtime_start' => $request->showtime_start,
                        'showtime_finish' => $request->showtime_finish
                    ]);
            } else {
                $query =  Showtime::where('id_event', $id)
                    ->update([
                        'showtime_start' => $request->showtime_start,
                        'showtime_finish' => $request->showtime_finish
                    ]);
                //dd('tidak berubah');
            }
            DB::commit();
            // all good

            return redirect('/show-time/' . $id)->with('status', 'Success Update Show Time');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return redirect('/show-time/' . $id)->with('failed', 'Failed Update Show Time');
        }
    }

    public function destroy(Request $request, $id)
    {
        // dd($request);
        // $id = decrypt($id);

        DB::beginTransaction();
        try {

            $deleteShowTime = Showtime::where('id', $id)->delete();

            DB::commit();
            // all good

            return redirect('/show-time/' . $id)->with('status', 'Success Delete Show Time');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/show-time/' . $id)->with('failed', 'Failed Delete Show Time');
        }
    }
}
