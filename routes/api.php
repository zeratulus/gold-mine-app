<?php

use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CountryController::class)->group(function () {
    Route::post('/countries', 'index');
    Route::post('/country/{id}', 'store')->whereUuid('id');
    Route::get('/country/{id}', 'show')->whereUuid('id');
    Route::delete('/country/{id}', 'destroy')->whereUuid('id');
});

Route::get('/report/{month}', function (Request $request) {
    //TODO: Generates report for a given month
})->whereNumber('month');


Route::get('/generate', function () {
    //TODO: Launch seeders here
});
