<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $districts = District::withCount(['user as tukang_count' => function ($query) {
            $query->whereHas('roles', function ($roleQuery) {
                $roleQuery->where('name', 'Tukang');
            });
        }])->get();

        return view("pages.home", compact('districts'));
    }
}
