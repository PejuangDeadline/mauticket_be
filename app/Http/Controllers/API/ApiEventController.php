<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;

class ApiEventController extends ApiBaseController
{
    public function eventSearch(Request $request){
        // dd('hai');
        $validator = Validator::make($request->all(), [
            'until' => 'required_with:from',
            'from' => 'required_with:until',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
    }
}
