<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Models\RefCode;

class ApiTransactionController extends ApiBaseController
{
    public function chartAdd(Request $request)
    {
        // Validate request data using the validate method
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|string|max:255',
            'id_ticket_category' => 'required|string|max:255',
            'id_event' => 'required|string|max:255',
            'id_showtime' => 'required|string|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer|min:1',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            // Loop through the qty value and insert records
            for ($i = 0; $i < $request->qty; $i++) { // Use $request->qty instead of $validatedData['qty']
                // Start a database transaction for each iteration
                DB::beginTransaction();

                // Create a new transaction record
                $transaction = TransactionTemp::create([
                    'id_user' => $request->id_user,
                    'id_ticket_category' => $request->id_ticket_category,
                    'id_event' => $request->id_event,
                    'id_showtime' => $request->id_showtime,
                    'price' => $request->price,
                ]);

                // Commit the transaction
                DB::commit();
            }

            // Include input data and processed quantity in the success response
            $response = [
                'input_data' => $request->all(), // Use $request->all() to get all validated data
                'processed_qty' => $request->qty,
            ];
            return $this->sendResponse($response,'Transactions added successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function chartDelete($id_chart){
        
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

    public function checkoutStore(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'id_user' => 'required|integer',
            'no_transaction' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            // ... add more validation rules for other fields
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create the main transaction record
            $transaction = Transaction::create([
                'id_user' => $validatedData['id_user'],
                'no_transaction' => $validatedData['no_transaction'],
                // ... add values for other fields
            ]);

            // Process the items and create transaction detail records
            foreach ($validatedData['items'] as $item) {
                TransactionDetail::create([
                    'transaction_header_id' => $transaction->id,
                    'id_ticket_category' => $item['id_ticket_category'],
                    'id_event' => $item['id_event'],
                    'id_showtime' => $item['id_showtime'],
                    'price' => $item['price'],
                    // ... add values for other fields
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Include a success message in the response
            $responseData = [
                'message' => 'Checkout completed successfully',
            ];

            return response()->json($responseData, 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
        }
    }

    public function paymentUpload(Request $request){
        
    }

    public function paymentSubmit(Request $request){
        
    }
}
