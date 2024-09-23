<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class InfoTukangController extends Controller
{
    public function index()
    {
        $districts = District::all();
        return view("pages.info-tukang", compact('districts'));
    }
}
