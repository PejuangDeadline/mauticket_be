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
        $refCodes = RefCode::where('is_active', 1)->orderBy('id')->get();
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

        $checkCode = RefCode::where('code', $refCode)->where('is_active', 1)->count();

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

    public function edit(Request $request, $id)
    {
        // dd($id, $request);
        $refCode = strtoupper($request->ref_code);
        $id_partner = auth()->user()->id_partner;

        DB::beginTransaction();
        try {

            $query =  RefCode::where('id', $id)
                ->update([
                    'id_partner' => $id_partner,
                    'code' => $refCode,
                    'type' => 'Per Item',
                    'value' => $request->ref_value,
                    'is_active' => '1',
                ]);

            DB::commit();
            // all good
            return redirect('/ref-code')->with('status', 'Success Update Refferal Code');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            // something went wrong
            return redirect('/ref-code')->with('failed', 'Failed Update Refferal Code');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            RefCode::where('id', $id)
                ->update([
                    'is_active' => '0'
                ]);

            DB::commit();
            // all good
            return redirect('/ref-code')->with('status', 'Success Delete Refferal Code');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            // something went wrong
            return redirect('/ref-code')->with('failed', 'Failed Delete Refferal Code');
        }
    }
}
