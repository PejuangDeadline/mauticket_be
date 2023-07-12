<?php

namespace App\Http\Controllers;

use App\Models\MstPartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MstPartnerController extends Controller
{
    public function index(){
        return view('partner.index');
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
