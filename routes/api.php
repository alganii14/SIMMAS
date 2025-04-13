<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InfaqController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\DonaturController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('donatur', DonaturController::class);

Route::apiResource('user', RegisterController::class);
Route::apiResource('infaq', InfaqController::class);

