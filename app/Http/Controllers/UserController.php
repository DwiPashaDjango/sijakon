<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view("dashboard.user.index");
    }

    public function create()
    {
        return view("dashboard.user.create");
    }

    public function edit($id)
    {
        return view("dashboard.user.edit", compact('id'));
    }
}
