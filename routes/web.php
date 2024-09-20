<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\CraftsmanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::group([
    "middleware" => ["auth_login"],
], function () {
    Route::get("/login", [AuthController::class, "login"])->name("auth.login");
    Route::post("/login", [AuthController::class, "login_post"]);
    Route::post("/logout", [AuthController::class, "logout_post"])->withoutMiddleware(["auth_login"]);
});

Route::group([
    "prefix" => "dashboard",
    "middleware" => ["guest_login"],
], function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    Route::prefix('pengguna')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.pengguna');
        Route::get('/create', [UserController::class, 'create'])->name('admin.pengguna.create');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('admin.pengguna.edit');
    });

    Route::prefix('tukang')->group(function () {
        Route::get('/', [CraftsmanController::class, 'index'])->name('admin.tukang');
        Route::get('/create', [CraftsmanController::class, 'create'])->name('admin.tukang.create');
        Route::get('/{id}/edit', [CraftsmanController::class, 'edit'])->name('admin.tukang.edit');
    });

    Route::prefix('bidang')->group(function () {
        Route::get('/', [BidangController::class, 'index'])->name('admin.bidang');
    });
});

Route::get('/links', function () {
    Artisan::call('storage:link');
});
