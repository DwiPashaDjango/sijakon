<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SumberProyek;
use Illuminate\Http\Request;

class InfoProyekController extends Controller
{
    public function index() {
        $sumberProyek = SumberProyek::all();
        return view("pages.info-proyek", compact('sumberProyek'));
    }
}
