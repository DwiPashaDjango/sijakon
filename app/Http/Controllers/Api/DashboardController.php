<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Response::json([
            "status" => true,
            "message" => "success.",
            "data" => [
                "statistics" => "Dashboard"
            ]
        ]);
    }
}
