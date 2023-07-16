<?php

namespace App\Http\Controllers;

use App\Models\MstPartner;
use App\Models\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MstPartnerController extends Controller
{
    public function index(){
        $institutions = MstPartner::get();
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
        return view('partner.index',compact('institutions','provinces'));
    }

    public function storePartner(Request $request){
        // dd($request->all());

        $request->validate([
            "partner" => "required",
            "pic" => "required",
            "pic_contact" => "required"
        ]);

        DB::beginTransaction();
        try {
            $query = MstPartner::create([
                'partner_name' => $request->partner,
                'pic_name' => $request->pic,
                'pic_contact' => $request->pic_contact
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
}
