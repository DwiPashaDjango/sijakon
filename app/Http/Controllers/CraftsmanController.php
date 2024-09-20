<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CraftsmanController extends Controller
{
    public function index()
    {
        return view('dashboard.tukang.index');
    }

    public function create()
    {
        return view('dashboard.tukang.create');
    }

    public function edit($id)
    {
        return view('dashboard.tukang.edit', compact('id'));
    }
}
