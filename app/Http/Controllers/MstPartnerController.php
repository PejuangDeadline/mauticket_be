<?php

namespace App\Http\Controllers;

use App\Models\MstPartner;
use Illuminate\Http\Request;
use App\Models\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\searchAreaTrait;

class MstPartnerController extends Controller
{
    use searchAreaTrait;
    public function index()
    {
        $partner = MstPartner::select('*')
        ->get();

        return view('partner.index',compact('partner'));
    }

    public function storePartner(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "partner" => "required",
            "pic" => "required",
            "pic_contact" => "required"
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
        $created_by=auth()->user()->email;

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

            $query = MstPartner::create([
                'partner_name' => $request->partner,
                'pic_name' => $request->pic,
                'pic_contact' => $request->pic_contact,
                'contact_1' => $request->contact_1,
                'contact_2' => $request->contact_2,
                'partner_addr' => $request->partner_addr,
                'province' => $province_name,
                'city' => $city_name,
                'district' => $district_name,
                'sub_district' => $subdistrict_name,
                'zip_code' => $request->zip_code,
                'is_active' => $request->is_active,
                'npwp' => $request->npwp,
                'created_by' => $request->created_by,
            ]);

            DB::commit();
            // all good

            return redirect('/partner')->with('status','Success Add Partner');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/partner')->with('failed','Failed Add Partner');
        }
    }
    public function StoreUpdatePartner(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "partner" => "required",
            "pic" => "required",
            "pic_contact" => "required"
        ]);

        $id_partner = $request->id_partner;
        $partner = MstPartner::where('id',$id_partner)->first();

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
        $partner->province = $province_name;
        $partner->city = $city_id;
        $partner->district = $district_id;
        $partner->sub_district = $subdistrict_id;

        DB::beginTransaction();

        try {
            if($partner->isDirty())
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

                $query =  MstPartner:: where('id',$request->id_profile)
                    ->update([
                        'partner_name' => $request->partner,
                        'pic_name' => $request->pic,
                        'pic_contact' => $request->pic_contact,
                        'contact_1' => $request->contact_1,
                        'contact_2' => $request->contact_2,
                        'partner_addr' => $request->partner_addr,
                        'province' => $province_name,
                        'city' => $city_name,
                        'district' => $district_name,
                        'sub_district' => $subdistrict_name,
                        'zip_code' => $request->zip_code,
                        'is_active' => $request->is_active,
                        'npwp' => $request->npwp,
                        'created_by' => $request->created_by,
                    ]);
            }
            else
            {
                //dd('tidak berubah');
                $query =  MstPartner:: where('id',$request->id_profile)
                    ->update([
                        'partner_name' => $request->partner,
                        'pic_name' => $request->pic,
                        'pic_contact' => $request->pic_contact,
                        'contact_1' => $request->contact_1,
                        'contact_2' => $request->contact_2,
                        'partner_addr' => $request->partner_addr,
                        'zip_code' => $request->zip_code,
                        'is_active' => $request->is_active,
                        'npwp' => $request->npwp,
                        'created_by' => $request->created_by,
                    ]);
            }

            DB::commit();
            // all good

            return redirect('/partner')->with('status','Success Update Partner');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/partner')->with('failed','Failed Update Partner');
        }
    }
}
