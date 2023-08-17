<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ApiBaseController;
use App\Models\RefCode;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionTemp;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Rule;
use App\Models\Event;

class ApiTransactionController extends ApiBaseController
{
    public function chartAdd(Request $request)
    {
        // Validate request data using the validate method
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'id_ticket_category' => 'required|integer',
            'id_event' => 'required|integer',
            'id_showtime' => 'required|integer',
            'price' => 'required|numeric',
            'qty' => 'required|integer|min:1',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        try {
            // Loop through the qty value and insert records
            for ($i = 0; $i < $request->qty; $i++) {
                // Start a database transaction for each iteration
                DB::beginTransaction();

                // Create a new transaction record
                TransactionTemp::create([
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
                 $request->all(),
            ];
            return $this->sendResponse($response, 'Chart added successfully', 201);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            return $this->sendError('An error occurred', $e->getMessage(), 500);
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
        // Validate request data using the validate method
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'id_event' => 'required|integer',
            'ref_code' => 'required|string', 
            'discount' => 'required|numeric', 
            'no_seat' => ['required', 'string', 'regex:/^\[\w+(,\w+)*\]$/'], // Validate the format
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        // Initialize variables
        $id_user = $request->id_user;
        $id_event = $request->id_event;
        $ref_code = $request->ref_code;
        $discount = $request->discount;
        $no_seat = $request->no_seat;
        $tax = (int) (float) Rule::where('rule_name', 'Tax')->value('rule_value');
        $platform_fee = (int) (float) Event::join('mst_partners', 'events.id_partner', '=', 'mst_partners.id')
            ->where('events.id', $id_event)
            ->value('mst_partners.platform_fee');

        // Query TransactionTemp records
        $queryTransactionTemp = TransactionTemp::where('id_user', $id_user)
        ->where('id_event', $id_event)
        ->orderBy('id_ticket_category', 'desc');
        $queryTransactionTempsumPrice = $queryTransactionTemp->sum('price');
        $getTransactionTempCount = $queryTransactionTemp->count();
        $getTransactionTempInfo = $queryTransactionTemp->get();
        
        // Perform calculations
        $grand_total = $queryTransactionTempsumPrice - $discount + ( ($queryTransactionTempsumPrice - $discount) * $tax / 100);
        $partner_portion = $grand_total - ($grand_total * ($platform_fee / 100));
        $status = '0';

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Insert data into YourTransactionTable
            $transactionHeader = TransactionHeader::create([
                'id_user' => $id_user,
                'no_transaction' => $this->generateNoTransaction(), // You need to implement this function
                'qty' => $getTransactionTempCount,
                'sub_total' => $queryTransactionTempsumPrice,
                'ref_code' => $ref_code,
                'discount' => $discount,
                'tax' => $tax,
                'platform_fee' => $platform_fee,
                'grand_total' => $grand_total,
                'partner_portion' => $partner_portion,
                'status' => $status,
            ]);

            foreach ($getTransactionTempInfo as $index => $tempInfo) {
                // Remove square brackets and split the no_ticket string into an array
                $seatNumbers = explode(',', str_replace(['[', ']'], '', $no_seat));
                $seatNumber = $seatNumbers[$index] ?? null; // Get the corresponding ticket number or set to null if not found
                TransactionDetail::create([
                    'transaction_header_id' => $transactionHeader->id,
                    'id_ticket_category' => $tempInfo->id_ticket_category,
                    'id_event' => $tempInfo->id_event,
                    'id_showtime' => $tempInfo->id_showtime,
                    'price' => $tempInfo->price,
                    'no_seat' => $seatNumber,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Return a success response
            return $this->sendResponse('Transaction created successfully', 201);
        } catch (\Throwable $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            // Return an error response
            return $this->sendError('An error occurred', $e->getMessage(), 500);
        }
    }


    public function paymentUpload(Request $request){
        
    }

    public function paymentSubmit(Request $request){
        
    }

    function generateNoTransaction() {
        $timestamp = now()->format('YmdHis'); // Current date and time in the format: YearMonthDayHourMinuteSecond
        $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
        
        return $timestamp . $randomNumber;
    }
    
}
