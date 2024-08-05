<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AlatUserController;
use App\Http\Controllers\AvalancheEffectController;
use App\Http\Controllers\HakAksesController;
use App\Http\Controllers\HistoryAksesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('alat', AlatController::class);
    Route::apiResource('profile', ProfileController::class)->only('show', 'update');
    Route::resource('avalanche-effect', AvalancheEffectController::class)->only('index', 'store');
    Route::prefix('history-akses')->name('history-akses.')->controller(HistoryAksesController::class)->group(function () {
        Route::get('/{user}', 'index')->name('index');
        Route::post('/', 'store')->name('store');
    });
    Route::prefix('hak-akses')->name('hak-akses.')->controller(HakAksesController::class)->group(function () {
        Route::get('/{user}', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('/{alat}/show', 'show')->name('show');
        Route::delete('/{hak_akse}', 'destroy')->name('destroy');
    });
});
