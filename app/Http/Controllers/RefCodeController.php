<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\RefCode;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefCodeController extends Controller
{
    public function index(){
        //dd('hi');
        $refCodes = RefCode::orderBy('id')->get();
        $refTypes = Dropdown::where('category', 'Type Referral')->get();
        // dd($refTypes);
        return view('ref_code.index', compact('refTypes', 'refCodes'));
    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            "ref_code" => "required",
            "ref_value" => "required"
        ]);

        $refCode = strtoupper($request->ref_code);

        $checkCode = RefCode::where('code',$refCode)->count();

        if($checkCode > 0){
            return redirect('/ref-code')->with('failed','Code Already Exist');
        }

        $id_partner = auth()->user()->id_partner;
        // dd($id_partner);

        DB::beginTransaction();
        try {
            $storeRefCode = RefCode::create([
                'id_partner' => $id_partner,
                'code' => $refCode,
                'type' => 'Per Item',
                'value' => $request->ref_value,
                'is_active' => '1',
            ]);

            DB::commit();
            // all good

            return redirect('/ref-code')->with('status','Success Add Refferal Code');
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

            return redirect('/ref-code')->with('failed','Failed Add Refferal Code');
        }
    }
}
