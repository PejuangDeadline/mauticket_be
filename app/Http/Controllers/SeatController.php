<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index($idCategory)
    {
        // dd($idCategory);
        $seats = Seat::where('id_category', $idCategory)
            ->leftJoin('ticket_categories', 'ticket_categories.id', '=', 'seats.id_category')
            ->orderby('seats.id_category')
            ->get();
        // dd($seats);
        return view('seats.show', compact('seats'));
    }
}
