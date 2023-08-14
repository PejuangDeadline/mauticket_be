<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function index($idCategory)
    {
        // dd($idCategory);
        $seats = Seat::where('id_category', $idCategory)->get();

        return view('seats.show', compact('seats'));
    }

}
