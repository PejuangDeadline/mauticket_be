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
use App\Models\TicketCategory;
use App\Models\Showtime;
use App\Models\TicketPayment;

class EventController extends Controller
{
    use searchAreaTrait;
    //
    public function index()
    {
        $id_partner= auth()->user()->id_partner;
        $event = Event::leftJoin('mst_partners', 'events.id_partner', '=', 'mst_partners.id')
        ->select('events.*', 'mst_partners.partner_name')
        ->where('events.id_partner', $id_partner)
        ->get();
        //dd($event);

        //getPartner
        $id_partner = auth()->user()->id_partner;
        $getPartner = MstPartner::where('id',$id_partner)->orderBy('partner_name', 'asc')->first();
        //dd($getPartner);
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
         //dd($request->all());

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
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Create Event');
        }
    }

    public function storeUpdateEvent(Request $request)
    {
        //dd($request->all());

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

        $id = $request->id;
        $event = Event::where('id',$id)->first();
        //dd($event);
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
        // dd($province_name);
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
                $province_name = $this->provinceName($token, $province_id);
                //Area City by ID
                $city_name = $this->cityName($token, $city_id);
                //Area District by ID
                $district_name = $this->districtName($token, $district_id);
                //Area Subdistrict by ID
                $subdistrict_name = $this->subdistrictName($token, $subdistrict_id);

                $query =  Event:: where('id',$id)
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
                    'is_active' => $request->is_active,
                    'created_by' => $request->created_by,
                ]);
            }
            else
            {
                //dd('tidak berubah');
                $query =  Event:: where('id',$id)
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
                    'is_active' => $request->is_active,
                    'created_by' => $request->created_by,
                ]);
            }
            DB::commit();
            // all good

            return redirect('/event')->with('status','Success Update Event');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Update Event');
        }
    }

    public function destroyEvent($id){
        // dd('destroy');
        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  Event::where('id',$id)
                    ->update([
                        'is_active' => '0',
                        'created_by' => $created_by,
                    ]);
            DB::commit();
            // all good

            return redirect('/event')->with('status','Success Delete Event');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Delete Event');
        }
    }

    public function activeEvent($id){
        // dd('destroy');
        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  Event::where('id',$id)
                    ->update([
                        'is_active' => '1',
                        'created_by' => $created_by,
                    ]);
            DB::commit();
            // all good

            return redirect('/event')->with('status','Success Activate Event');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed','Failed Activate Event');
        }
    }

    public function detailEvent($id){
        $id = decrypt($id);
        $event = Event::leftJoin('mst_partners', 'events.id_partner', '=', 'mst_partners.id')
        ->select('events.*', 'mst_partners.partner_name')
        ->where('events.id', $id)
        ->first();
        $ticketCategory = TicketCategory::where('id_event',$id)->get();
        $showTime = Showtime::where('id_event',$id)->get();
        $ticketPayment = TicketPayment::where('id_event',$id)->get();
        return view('event.detail',compact('event','ticketCategory','id','showTime','ticketPayment'));
    }

    public function UploadAttachmentVenue(Request $request,$id)
    {
        //dd($request->id);
        $request->validate([
            'venue' => 'required|mimes:jpeg,jpg,png,pdf|max:3048'
        ]);

        DB::beginTransaction();

        try {

            if ($request->hasFile('venue')) {
                $path_attach = $request->file('venue');
                $url = $path_attach->move('storage/venue', $path_attach->hashName());
                // $image = "data:image/png;base64,".base64_encode(file_get_contents($request->file('attach')->path()));
            }

            // dd($image);

            $store =  Event::where('id',$id)
                    ->update([
                        'attach_venue' => $url
                    ]);


            DB::commit();
            // all good

            return redirect('/event')->with('status', 'Success Add Venue Image');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed', 'Failed Add Venue Image');
        }
    }

    public function UploadAttachmentBanner(Request $request,$id)
    {
        //dd($request->id);
        $request->validate([
            'banner' => 'required|mimes:jpeg,jpg,png,pdf|max:3048'
        ]);

        DB::beginTransaction();

        try {

            if ($request->hasFile('banner')) {
                $path_attach = $request->file('banner');
                $url = $path_attach->move('storage/banner', $path_attach->hashName());
                // $image = "data:image/png;base64,".base64_encode(file_get_contents($request->file('attach')->path()));
            }

            // dd($image);

            $store =  Event::where('id',$id)
                    ->update([
                        'banner' => $url
                    ]);


            DB::commit();
            // all good

            return redirect('/event')->with('status', 'Success Add Banner Image');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/event')->with('failed', 'Failed Add Banner Image');
        }
    }
}
