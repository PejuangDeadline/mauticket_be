<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TransactionTemp;

class ApiTransactionController extends Controller
{
    public function chartAdd(Request $request)
{
    // Validate request data
    $validatedData = $request->validate([
        'id_user' => 'required|string|max:255',
        'id_ticket_category' => 'required|string|max:255',
        'id_event' => 'required|string|max:255',
        'id_showtime' => 'required|string|max:255',
        'price' => 'required|numeric',
        'qty' => 'required|integer|min:1',
    ]);

    try {
        // Loop through the qty value and insert records
        for ($i = 0; $i < $validatedData['qty']; $i++) {
            // Start a database transaction for each iteration
            DB::beginTransaction();

            // Create a new transaction record
            $transaction = TransactionTemp::create([
                'id_user' => $validatedData['id_user'],
                'id_ticket_category' => $validatedData['id_ticket_category'],
                'id_event' => $validatedData['id_event'],
                'id_showtime' => $validatedData['id_showtime'],
                'price' => $validatedData['price'],
            ]);

            // Commit the transaction
            DB::commit();
        }

        // Include input data and processed quantity in the success response
        $responseData = [
            'message' => 'Transactions added successfully',
            'input_data' => $validatedData,
            'processed_qty' => $validatedData['qty'],
        ];

        return response()->json($responseData, 201);
    } catch (\Exception $e) {
        // Rollback the transaction if an exception occurs
        DB::rollback();

        return response()->json(['message' => 'An error occurred', 'error' => $e->getMessage()], 500);
    }
}

    public function chartDelete($id_chart){
        
    }

    public function refCodeCheck(Request $request){
        
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
