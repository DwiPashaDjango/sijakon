<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\District;
use App\Models\Proyek;
use App\Models\User;
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

        $countTukang = User::role('Tukang')->count();
        $countBadanUsaha = BadanUsaha::count();
        $countProyek = Proyek::count();

        return view("pages.home", compact('districts', 'countTukang', 'countBadanUsaha', 'countProyek'));
    }
}
