<?php

namespace App\Http\Controllers;

use App\Imports\SeatsImport;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeatsHeaderTemplateExport;
use App\Models\Seat;

class ExcelController extends Controller
{
    public function downloadTemplate($idEvent, $idCategory)
    {
        $category = TicketCategory::where('id_event', $idEvent)
            ->where('id', $idCategory)
            ->first()->category;

        // dd($category);
        return Excel::download(new SeatsHeaderTemplateExport, $category . '.xlsx');
    }

    public function importData(Request $request, $idEvent, $idCategory)
    {
        // dd($request);
        $request->validate([
            'file' => 'required'
        ]);

        $file = $request->file('file');
        // dd($file);
        $importedData = Excel::toArray(new SeatsImport, $file, null, \Maatwebsite\Excel\Excel::XLSX); // Specify the file type

        $createdCount = 0;
        $duplicateCount = 0;

        // Start the loop from the second row (index 1) to skip the header
        for ($i = 1; $i < count($importedData[0]); $i++) {
            $row = $importedData[0][$i];

            $result = Seat::firstOrCreate(
                ['id_category' => $idCategory, 'seat_number' => $row[0]],
                ['is_active' => '1']
            );

            if ($result->wasRecentlyCreated) {
                $createdCount++;
            } else {
                $duplicateCount++;
            }
        }

        $message = "Data imported successfully. {$createdCount} new records added, {$duplicateCount} records already existed.";
        $id_en = encrypt($idEvent);
        return redirect('/ticket-category/' . $id_en)->with('status', $message);
    }
    
}
