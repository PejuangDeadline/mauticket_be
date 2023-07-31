<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Event;
use App\Models\Rule;
use App\Models\MstPartner;
use App\Models\Dropdown;
use App\Traits\searchAreaTrait;

class EventController extends Controller
{
    use searchAreaTrait;
    //
    public function index()
    {
        $event = Event::select('*')
        ->get();

        //getPartner
        $getPartner = MstPartner::orderBy('partner_name', 'asc')->get();

        //getEventCategory
        $getEventCategory = Dropdown::where('category', 'Event Category')
        ->orderBy('name_value', 'asc')
        ->get();

        //API Regional
        $ruleAuthRegional = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_AuthRegional = $ruleAuthRegional->rule_value;

        $ruleEmailRegional = Rule::where('rule_name', 'Email Auth Regional')->first();
        $emailRegional = $ruleEmailRegional->rule_value;

        $rulePasswordRegional = Rule::where('rule_name', 'Password Auth Regional')->first();
        $passwordRegional = $rulePasswordRegional->rule_value;

        $response = Http::post($url_AuthRegional, [
            'email' => $emailRegional,
            'password' => $passwordRegional,
        ]);

        $data = $response['data'];
        $token = $data['token'];

        //get list province
        $ruleApiProvince = Rule::where('rule_name', 'API List Province')->first();
        $url_ApiProvince = $ruleApiProvince->rule_value;

        $getProvince = Http::withToken($token)
            ->get($url_ApiProvince);
        $provinces = $getProvince['data'];
        //End API Regional

        return view('event.index',compact('event','provinces','getPartner','getEventCategory'));
    }

    public function storeEvent(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "id_partner" => "required",
            "event_category" => "required",
            "event_name" => "required",
            "highlight" => "required",
            "description" => "required",
            "event_address" => "required",
            "province_by_id" => "required",
            "city" => "required",
            "district" => "required",
            "subdistrict" => "required",
            "zip_code" => "required",
            "exchange_ticket_info" => "required",
            "tc_info" => "required",
            "including_info" => "required",
            "excluding_info" => "required",
            "facility" => "required",
        ]);

        //get Token Area
        $rule = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_getToken = $rule->rule_value;

        $ruleAuthUsers = Rule::where('rule_name', 'Email Auth Regional')->first();
        $authUsername = $ruleAuthUsers->rule_value;

        $ruleAuthPass = Rule::where('rule_name', 'Password Auth Regional')->first();
        $authPassword = $ruleAuthPass->rule_value;

        $response = Http::post($url_getToken, [
            'email' => $authUsername,
            'password' => $authPassword,
        ]);

        $data = $response['data'];
        $token = $data['token'];

        // create by email
        // $created_by=auth()->user()->email;

        DB::beginTransaction();
        try {

            //Area Province by ID
            $province_name = $this->provinceName($token, $request->province_by_id);
            //Area City by ID
            $city_name = $this->cityName($token, $request->city);
            //Area District by ID
            $district_name = $this->districtName($token, $request->district);
            //Area Subdistrict by ID
            $subdistrict_name = $this->subdistrictName($token, $request->subdistrict);

            $query = Event::create([
                'id_partner' => $request->id_partner,
                'event_category' => $request->event_category,
                'event_name' => $request->event_name,
                'highlight' => $request->highlight,
                'description' => $request->description,
                'event_address' => $request->event_address,
                'province' => $province_name,
                'city' => $city_name,
                'district' => $district_name,
                'sub_district' => $subdistrict_name,
                'zip_code' => $request->zip_code,
                'exchange_ticket_info' => $request->exchange_ticket_info,
                'tc_info' => $request->tc_info,
                'including_info' => $request->including_info,
                'excluding_info' => $request->excluding_info,
                'facility' => $request->facility,
                'is_active' => $request->is_active,
                'created_by' => $request->created_by,
            ]);

            DB::commit();
            // all good

            return redirect('/event')->with('status','Success Create Event');
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Create Event');
        }
    }

    public function storeUpdateEvent(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "id_partner" => "required",
            "event_category" => "required",
            "event_name" => "required",
            "highlight" => "required",
            "description" => "required",
            "event_address" => "required",
            "province" => "required",
            "city" => "required",
            "district" => "required",
            "sub_district" => "required",
            "zip_code" => "required",
            "exchange_ticket_info" => "required",
            "tc_info" => "required",
            "including_info" => "required",
            "excluding_info" => "required",
            "facility" => "required",
            "start_date" => "required",
            "end_date" => "required",
            "showtime_start" => "required",
            "showtime_end" => "required",
        ]);

        $id_partner = $request->id_partner;
        $event = Event::where('id',$id_partner)->first();

        //get id if update regional
        $province_id = $request->province_by_id;
        $city_id = $request->city;
        $district_id = $request->district;
        $subdistrict_id = $request->subdistrict;

        //get Token Area
        $rule = Rule::where('rule_name', 'API Auth Regional')->first();
        $url_getToken = $rule->rule_value;

        $ruleAuthUsers = Rule::where('rule_name', 'Email Auth Regional')->first();
        $authUsername = $ruleAuthUsers->rule_value;

        $ruleAuthPass = Rule::where('rule_name', 'Password Auth Regional')->first();
        $authPassword = $ruleAuthPass->rule_value;

        $response = Http::post($url_getToken, [
            'email' => $authUsername,
            'password' => $authPassword,
        ]);

        $data = $response['data'];
        $token = $data['token'];

        //Area Province by ID
        $province_name = $this->provinceName($token, $request->province_by_id);

        // compare data with database
        $event->province = $province_name;
        $event->city = $city_id;
        $event->district = $district_id;
        $event->sub_district = $subdistrict_id;

        DB::beginTransaction();
        try {
            if($event->isDirty())
            {
                //dd('berubah');
                //Area Province by ID
                $province_name = $this->provinceName($token, $request->province_by_id);
                //Area City by ID
                $city_name = $this->cityName($token, $request->city);
                //Area District by ID
                $district_name = $this->districtName($token, $request->district);
                //Area Subdistrict by ID
                $subdistrict_name = $this->subdistrictName($token, $request->subdistrict);

                $query =  Event:: where('id',$request->id_partner)
                    ->update([
                    'id_partner' => $request->id_partner,
                    'event_category' => $request->event_category,
                    'event_name' => $request->event_name,
                    'highlight' => $request->highlight,
                    'description' => $request->description,
                    'event_address' => $request->event_address,
                    'province' => $province_name,
                    'city' => $city_name,
                    'district' => $district_name,
                    'sub_district' => $subdistrict_name,
                    'zip_code' => $request->zip_code,
                    'exchange_ticket_info' => $request->exchange_ticket_info,
                    'tc_info' => $request->tc_info,
                    'including_info' => $request->including_info,
                    'excluding_info' => $request->excluding_info,
                    'facility' => $request->facility,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'showtime_start' => $request->showtime_start,
                    'showtime_end' => $request->showtime_end,
                    'is_active' => $request->is_active,
                    'created_by' => $request->created_by,
                ]);
            }
            else
            {
                $query =  Event:: where('id',$request->id_partner)
                    ->update([
                    'id_partner' => $request->id_partner,
                    'event_category' => $request->event_category,
                    'event_name' => $request->event_name,
                    'highlight' => $request->highlight,
                    'description' => $request->description,
                    'event_address' => $request->event_address,
                    'zip_code' => $request->zip_code,
                    'exchange_ticket_info' => $request->exchange_ticket_info,
                    'tc_info' => $request->tc_info,
                    'including_info' => $request->including_info,
                    'excluding_info' => $request->excluding_info,
                    'facility' => $request->facility,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'showtime_start' => $request->showtime_start,
                    'showtime_end' => $request->showtime_end,
                    'is_active' => $request->is_active,
                    'created_by' => $request->created_by,
                ]);
                //dd('tidak berubah');
            }
            DB::commit();
            // all good

            return redirect('/event')->with('status','Success Update Event');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Update Event');
        }
    }
}
