<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Visit\VisitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('login','login');
    Route::post('register','register');
    Route::get('logout','logout')->name('auth.logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('visits')->controller(VisitController::class)->group(function () {
        Route::get('/get', 'get')->name('visits.get');
        Route::get('/on-map', 'onMap')->name('visits.onMap');
    });
    Route::apiResource('visits', VisitController::class);
});
