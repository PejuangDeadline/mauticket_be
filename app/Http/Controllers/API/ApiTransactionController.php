<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Models\RefCode;
use App\Models\TransactionTemp;

class ApiTransactionController extends ApiBaseController
{
    public function chartAdd(Request $request){
        
    }

    public function chartDelete($id_chart){
        //delete Transaction Temp
        $delTemp = TransactionTemp::where('id', $id_chart)->delete();

        // dd($delTemp);
        if ($delTemp) {
            return $this->sendResponse($delTemp, 'Success Delete Transaction Temp');
        } else {
            return $this->sendError('Validation Error.', 'Transaction Temp is Invalid');
        }
    }

    public function refCodeCheck(Request $request){
        // dd('hai');
        $validator = Validator::make($request->all(), [
            'id_refcode' => 'required'
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        //checkRefCode
        $qcheck = RefCode::where('id',$request->id_refcode)->first();

        // dd($qcheck);
        if($qcheck->qty > 0){
            return $this->sendResponse($qcheck, 'Success Inquiry Ref Code.');
        }
        else{
            return $this->sendError('Validation Error.', 'Referral Code is Invalid');    
        }
    }

    public function seatCheck(Request $request){
        
    }

    public function checkoutStore(Request $request){
        
    }

    public function paymentUpload(Request $request){
        
    }

    public function paymentSubmit(Request $request){
        
    }
}
