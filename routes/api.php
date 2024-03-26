<?php

use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CountryController::class)->group(function () {
    Route::post('/countries', 'index');
    Route::post('/country/{id}', 'store');
    Route::get('/country/{id}', 'show');
    Route::delete('/country/{id}', 'destroy');
});

Route::get('/generate', function () {
    //TODO: Launch seeders here
});
