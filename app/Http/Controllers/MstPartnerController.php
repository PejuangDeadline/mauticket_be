<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Traits\searchAreaTrait;
use App\Models\Rule;
use App\Models\MstPartner;
use App\Models\ContractPartner;

class MstPartnerController extends Controller
{
    use searchAreaTrait;
    public function index()
    {
        $partner = MstPartner::leftJoin('contract_partners', 'mst_partners.id', '=', 'contract_partners.id_partner')
        ->select('mst_partners.*', 'contract_partners.id_partner', 'contract_partners.start_date', 'contract_partners.end_date')
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

        return view('partner.index',compact('partner','provinces'));
    }

    public function storePartner(Request $request)
    {
        //dd('hi');
        // dd($request->all());

        $request->validate([
            "partner_name" => "required",
            "pic_name" => "required",
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
        $created_by = auth()->user()->email;

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
                'partner_name' => $request->partner_name,
                'pic_name' => $request->pic_name,
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
                'created_by' => $created_by,
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
        //dd('hi');
        // dd($request->all());

        $request->validate([
            "partner_name" => "required",
            "pic_name" => "required",
            "pic_contact" => "required"
        ]);

        $id_partner = $request->id_partner;
        $partner = MstPartner::where('id',$id_partner)->first();

        //get id if update regional
        $province_id = $request->province_by_id;
        $city_id = $request->city;
        $district_id = $request->district;
        $subdistrict_id = $request->sub_district;

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

        // create by email
        $created_by = auth()->user()->email;

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

                $query =  MstPartner::where('id',$request->id_partner)
                    ->update([
                        'partner_name' => $request->partner_name,
                        'pic_name' => $request->pic_name,
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
                        'created_by' => $created_by,
                    ]);
            }
            else
            {
                //dd('tidak berubah');
                $query =  MstPartner::where('id',$request->id_partner)
                    ->update([
                        'partner_name' => $request->partner_name,
                        'pic_name' => $request->pic_name,
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


    public function deletePartner($id){
        //dd('hi');
        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  MstPartner::where('id',$id)
                    ->update([
                        'is_active' => '0',
                        'created_by' => $created_by,
                    ]);
            DB::commit();
            // all good

            return redirect('/partner')->with('status','Success Delete Partner');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/partner')->with('failed','Failed Delete Partner');
        }
    }

    public function storeContract(Request $request){
        //dd('hi');
        //dd($request->all());

        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
        ]);

        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {

            $query =  ContractPartner::create([
                'id_partner' => $request->id_partner,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'is_active' => '1',
            ]);

            $query =  ContractPartner:: where('id',$request->id_partner)
                    ->update([
                        'is_active' => '1',
                    ]);

            DB::commit();
            // all good

            return redirect('/partner')->with('status','Success Add Contract');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/partner')->with('failed','Failed Add Contract');
        }
    }

    public function updateContract(Request $request){
        //dd('hi');
        //dd($request->all());

        $request->validate([
            "start_date" => "required",
            "end_date" => "required",
        ]);

        $id_contract = $request->id;
        $contractPartner = ContractPartner::where('id',$id_contract)->first();
        //dd($contractPartner);

        // compare data with database
        $contractPartner->start_date = $request->start_date;
        $contractPartner->end_date = $request->end_date;
        $contractPartner->id_partner = $request->id_partner;

        // create by email
        $created_by = auth()->user()->email;

        DB::beginTransaction();
        try {
            if($contractPartner->isDirty())
            {
                //dd('berubah');

                $query =  ContractPartner::where('id',$id_contract)
                            ->update([
                                'id_partner' => $id_contract,
                                'start_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'is_active' => '1',
                            ]);
            }
            else
            {
                //dd('tidak berubah');
            }

            DB::commit();
            // all good

            return redirect('/partner')->with('status','Success Update Contract');
        } catch (\Exception $e) {
            //dd($e);
            DB::rollback();
            // something went wrong

            return redirect('/partner')->with('failed','Failed Update Contract');
        }
    }

}
