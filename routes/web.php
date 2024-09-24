<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadanUsahaController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\CraftsmanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\Pages\BerandaController;
use App\Http\Controllers\Pages\InfoBadanUsahaController;
use App\Http\Controllers\Pages\InfoEquipmentController;
use App\Http\Controllers\Pages\InfoTukangController;
use App\Http\Controllers\SumberDataController;
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


Route::get('/', [BerandaController::class, 'index'])->name('home');
Route::get('/info-tukang', [InfoTukangController::class, 'index'])->name('info.tukang');
Route::get('/info-badan-usaha', [InfoBadanUsahaController::class, 'index'])->name('info.badan.usaha');
Route::get('/info-peralatan', [InfoEquipmentController::class, 'index'])->name('info.peralatan');

Route::group([
    "middleware" => ["auth_login"],
], function () {
    Route::get("/auth", [AuthController::class, "login"])->name("auth.login");
    Route::post("/login", [AuthController::class, "login_post"]);
    Route::post("/logout", [AuthController::class, "logout_post"])->withoutMiddleware(["auth_login"]);
});

Route::group([
    "prefix" => "dashboard",
    "middleware" => ["guest_login"],
], function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard");

    Route::prefix('master-data')->group(function () {
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

        Route::prefix('district')->group(function () {
            Route::get('/', [DistrictController::class, 'index'])->name('admin.district');
        });

        Route::prefix('sumber_data')->group(function () {
            Route::get('/', [SumberDataController::class, 'index'])->name('admin.sumber-data');
        });
    });

    Route::prefix('badan-usaha')->group(function () {
        Route::get('/', [BadanUsahaController::class, 'index'])->name('admin.badan-usaha');
    });

    Route::prefix('equipment')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('admin.equipment');
    });
});

Route::get('/links', function () {
    Artisan::call('storage:link');
});
