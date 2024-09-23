<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BadanUsahaController;
use App\Http\Controllers\Api\BidangController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\CraftsmanController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SatuanController;
use App\Http\Controllers\Api\SumberDataController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post("/info-tukang", [CraftsmanController::class, "getCraftsmanByDistrict"]);

Route::group([
    "prefix" => "auth",
], function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::get("/show-account", [AuthController::class, "show"])->middleware(["auth:sanctum"]);
    Route::post("/logout", [AuthController::class, "logout"])->middleware(["auth:sanctum"]);
});

Route::group([
    "middleware" => ["auth:sanctum"],
], function () {
    Route::get("/dashboard", [DashboardController::class, "index"]);

    Route::group([
        "prefix" => "user",
    ], function () {
        Route::get("/", [UserController::class, "index"]);
        Route::post("/store", [UserController::class, "store"]);
        Route::get("/{id}/show", [UserController::class, "show"]);
        Route::put("/{id}/update", [UserController::class, "update"]);
        Route::delete("/{id}/destroy", [UserController::class, "destroy"]);
    });

    Route::group([
        "prefix" => "tukang",
    ], function () {
        Route::get("/", [CraftsmanController::class, "index"]);
        Route::post("/store", [CraftsmanController::class, "store"]);
        Route::get("/{id}/show", [CraftsmanController::class, "show"]);
        Route::post("/{id}/update", [CraftsmanController::class, "update"]);
        Route::delete("/{id}/destroy", [CraftsmanController::class, "destroy"]);
    });

    Route::group([
        "prefix" => "bidang",
    ], function () {
        Route::get("/", [BidangController::class, "index"]);
        Route::get("/select2", [BidangController::class, "select2"]);
        Route::post("/store", [BidangController::class, "store"]);
        Route::get("/{id}/show", [BidangController::class, "show"]);
        Route::put("/{id}/update", [BidangController::class, "update"]);
        Route::delete("/{id}/destroy", [BidangController::class, "destroy"]);
    });

    Route::group([
        "prefix" => "sumber-data",
    ], function () {
        Route::get("/", [SumberDataController::class, "index"]);
        Route::get("/select2", [SumberDataController::class, "select2"]);
        Route::post("/store", [SumberDataController::class, "store"]);
        Route::get("/{id}/show", [SumberDataController::class, "show"]);
        Route::put("/{id}/update", [SumberDataController::class, "update"]);
        Route::delete("/{id}/destroy", [SumberDataController::class, "destroy"]);
    });

    Route::group([
        "prefix" => "badan-usaha",
    ], function () {
        Route::get("/", [BadanUsahaController::class, "index"]);
        Route::post("/store", [BadanUsahaController::class, "store"]);
        Route::get("/{id}/show", [BadanUsahaController::class, "show"]);
        Route::put("/{id}/update", [BadanUsahaController::class, "update"]);
        Route::delete("/{id}/destroy", [BadanUsahaController::class, "destroy"]);
    });

    Route::group([
        "prefix" => "satuan",
    ], function () {
        Route::get("/select2", [SatuanController::class, "select2"]);
    });

    Route::group([
        "prefix" => "equipment",
    ], function () {
        Route::get("/", [EquipmentController::class, "index"]);
        Route::post("/store", [EquipmentController::class, "store"]);
        Route::get("/{id}/show", [EquipmentController::class, "show"]);
        Route::put("/{id}/update", [EquipmentController::class, "update"]);
        Route::delete("/{id}/destroy", [EquipmentController::class, "destroy"]);
    });
});

Route::prefix('district')->group(function () {
    Route::get("/", [CountryController::class, "index"]);
    Route::get("/select2", [CountryController::class, "select2"]);
    Route::post("/store", [CountryController::class, "store"]);
    Route::get("/{id}/show", [CountryController::class, "show"]);
    Route::put("/{id}/update", [CountryController::class, "update"]);
    Route::delete("/{id}/destroy", [CountryController::class, "destroy"]);
});
