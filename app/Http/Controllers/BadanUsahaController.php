<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BadanUsahaController extends Controller
{
    public function index()
    {
        return view('dashboard.badan-usaha.index');
    }
}
