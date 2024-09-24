<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\SumberData;
use Illuminate\Http\Request;

class InfoEquipmentController extends Controller
{
    public function index()
    {
        $sumberData = SumberData::all();
        return view("pages.info-peralatan", compact('sumberData'));
    }
}
