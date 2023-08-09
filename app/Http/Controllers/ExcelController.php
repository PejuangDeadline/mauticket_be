<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SeatsHeaderTemplateExport;
use App\Models\Event;
use App\Models\TicketCategory;

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
}
