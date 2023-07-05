<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function index()
    {
        dd('dropdown');
        return view('rules.index');
    }
}
