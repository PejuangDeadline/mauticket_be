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
use App\Models\Payment;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;
use App\Models\TicketPayment;

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

         // Check if available quantity is less than transaction quantity for the given showtime and ticket category
        $availableQty = Showtime::where([
            'id' => $request->id_showtime,
            'id_category' => $request->id_ticket_category,
        ])->value('qty');

        if (!$availableQty) {
            return $this->sendError('Showtime not found', 404);
        }

        if ($availableQty < $request->qty) {
            return $this->sendError('Insufficient quantity available', [], 400);
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
            return $this->sendResponse($response, 'Chart added successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollback();

            return $this->sendError('An error occurred', $e->getMessage(), 500);
        }
    }

    public function chartDelete($id_chart){
        //delete Transaction Temp
        $delTemp = TransactionTemp::where('id', $id_chart)->delete();

        // dd($delTemp);
        if ($delTemp) {
            return $this->sendResponse($delTemp, 'Success Delete Transaction Temp');
        } else {
            return $this->sendError('Validation Error.', 'ID Transaction Temp is Invalid');
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
        $query = RefCode::where('id',$request->id_refcode)->where('is_active','1');
        $qcheck = $query->first();
        $qcount = $query->count();

        if($qcount == '0'){
            return $this->sendError('Validation Error.', 'Referral Code is Invalid');   
        }

        // dd($qcheck);
        if($qcheck->qty > 0){
            return $this->sendResponse($qcheck, 'Success Inquiry Ref Code.');
        }
        else{
            return $this->sendError('Validation Error.', 'Referral Code is Invalid');    
        }
    }

    public function seatCheck(Request $request){
        $validator = Validator::make($request->all(), [
            'id_showtime' => 'required|integer',
            'no_seat' => 'required', // Validate the format
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $qcheckSeat = TransactionDetail::where('id_showtime',$request->id_showtime)
            ->where('no_seat',$request->no_seat)
            ->count();
        
        if($qcheckSeat > 0){
            return $this->sendError('Validation Error', 'No Seat '.$request->no_seat.' Already Taken');
        }
        else{
            return $this->sendResponse($qcheckSeat, 'Seat Available');
        }
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
       // Check if the collection is empty
        if ($getTransactionTempInfo->isEmpty()) {
            return $this->sendError('Transaction not found', 404);
        }

       // Group the transaction temp records by id_ticket_category and count the occurrences
        $idTicketCategoryCounts = $getTransactionTempInfo->groupBy('id_ticket_category');

        // Initialize an array to store the summary information
        $summary = [];

        $idTicketCategoryCounts->each(function ($groupedRecords, $id_ticket_category) use (&$summary) {
            // Assuming you have the same id_event and id_showtime for all records in each group
            $id_event = $groupedRecords[0]->id_event;
            $id_showtime = $groupedRecords[0]->id_showtime;

            $summary[] = [
                'id_event' => $id_event,
                'id_showtime' => $id_showtime,
                'id_ticket_category' => $id_ticket_category,
                'qty' => count($groupedRecords),
            ];
        });


        foreach ($summary as $item) {
            $idEvent = $item['id_event'];
            $idShowtime = $item['id_showtime'];
            $idTicketCategory = $item['id_ticket_category'];
            $qty = $item['qty'];
        
            $showtime = Showtime::where([
                'id_event' => $idEvent,
                'id_category' => $idTicketCategory,
                'id' => $idShowtime,
            ])->first();
        
            if (!$showtime) {
                return $this->sendError('Showtime not found', 404);
            }
        
            if ($qty > $showtime->qty) {
                return $this->sendError('Insufficient available seats for showtime', 422);
            }
        }

        // Perform calculations
        $grand_total = $queryTransactionTempsumPrice - $discount + ( ($queryTransactionTempsumPrice - $discount) * $tax / 100);
        $grand_total_final = $grand_total + ($grand_total * ($platform_fee / 100));
        $partner_portion = $grand_total;
        $status = '0';

        $tax = ( ($queryTransactionTempsumPrice - $discount) * $tax / 100);
        $platform_fee = ($grand_total * ($platform_fee / 100));

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
                'grand_total' => $grand_total_final,
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

                // Reduce the qty in the showtimes table
                $showtime = Showtime::where([
                    'id' => $tempInfo->id_showtime,
                    'id_event' => $tempInfo->id_event,
                    'id_category' => $tempInfo->id_ticket_category,
                ])->first();

                if ($showtime) {
                    $showtime->qty -= 1; // Reduce the qty by 1
                    $showtime->save();
            }
        }

            // Delete records from TransactionTemp
            $queryTransactionTemp->delete();

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

    public function paymentMethod($id_event){
        // dd('hai');
        $query = TicketPayment::where('id_event',$id_event);
        $checkMethodPay = $query->count();
        $methodPayments = $query->get();

        if($checkMethodPay > 0){
            return $this->sendResponse($methodPayments, 'Success Inquiry Payment Method.');
        }
        else{
            return $this->sendError('Data Not Found.', 'Payment Method Data Not Found');
        }
    }

    public function paymentUpload(Request $request)
    {
        // Initialize variables
        $transaction_header_id = $request->transaction_header_id;
        $payment_file = $request->file('payment_file');
        $payment_method = $request->payment_method;

        // Validate request data using the validate method
        $validator = Validator::make($request->all(), [
            'transaction_header_id' => 'required|integer',
            'payment_file' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Adjust allowed file types and size as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        try {
            // Convert the payment file to a base64-encoded string
            $base64PaymentFile = base64_encode(file_get_contents($payment_file->path()));

            // Check if the payment file for the given transaction already exists
            $existingPayment = Payment::where('id_transaction_header', $transaction_header_id)->first();
            if ($existingPayment) {
                return $this->sendError('Payment already exists for this transaction', [], 400);
            }

            // Check if a transaction with the same transaction_header_id already exists
            $existingTransaction = TransactionHeader::where('id', $transaction_header_id)->first();
            if (!$existingTransaction) {
                return $this->sendError('Transaction not found with this transaction_header_id', [], 404);
            }

            $getPaymentMethod = TicketPayment::where('id_event', TransactionDetail::where('transaction_header_id', $existingTransaction->id)->value('id_event'))->value('id');
            if ($getPaymentMethod != $payment_method) {
                return $this->sendError('Payment Method not found with this transaction_header_id', [], 404);
            }

            // Create a new Payment record with the base64-encoded payment file
            Payment::create([
                'id_transaction_header' => $transaction_header_id,
                'payment_file' => $base64PaymentFile,
                'status' => '0',
                'payment_method' => $payment_method,
            ]);

            // Return a success response
            return $this->sendResponse('Payment uploaded successfully', 201);
        } catch (\Throwable $e) {
            // Return an error response
            return $this->sendError('An error occurred', $e->getMessage(), 500);
        }
    }

    
    public function paymentSubmit(Request $request) {

        // Replace this with the actual token
     

        // Validate request data using the validate method
        $validator = Validator::make($request->all(), [
            'transaction_header_id' => 'required|string', // Assuming no_transaction is a string
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }
    
        try {
            $transaction_header_id = $request->transaction_header_id;

            // Check if the payment exists for this transaction
            $paymentExists = Payment::where('id_transaction_header', $transaction_header_id)->exists();
            if (!$paymentExists) {
            return $this->sendError('Payment has not been input yet for this transaction', [], 400);
            }

            // Check if the transaction exists with the given no_transaction
            $transaction = TransactionHeader::where('id', $transaction_header_id)->first();
            if (!$transaction) {
                return $this->sendError('Transaction not found with this no_transaction', [], 404);
            }

            $getUser =  User::where('id',$transaction->id_user)->first();
            $getEvenetInfo = Event::find(TransactionDetail::where('transaction_header_id', $transaction->id)->value('id_event'));
            // Check if the transaction is already successful
            if ($transaction->status == '1') {
                return $this->sendError('Transaction is already successful', [], 400);
            }
    
            // Update the status of transaction_headers to 1
            $transaction->update(['status' => '1']);
    
            // Update the status of payments related to this transaction
            Payment::where('id_transaction_header', $transaction_header_id)->update(['status' => '1']);
        
            // Replace this with the actual token
            Mail::to($getUser->email)->send(new InvoiceEmail($transaction,$getUser,$getEvenetInfo));

            // Return a success response
            return $this->sendResponse('Transaction marked as successful', 200);
        } catch (\Throwable $e) {
            // Return an error response
            return $this->sendError('An error occurred', $e->getMessage(), 500);
        }
    }
    
    function generateNoTransaction() {
        $timestamp = now()->format('YmdHis'); // Current date and time in the format: YearMonthDayHourMinuteSecond
        $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
        
        return $timestamp . $randomNumber;
    }
    
}
