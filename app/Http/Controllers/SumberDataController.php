<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SumberDataController extends Controller
{
    public function index()
    {
        return view('dashboard.sumber-data.index');
    }
}
