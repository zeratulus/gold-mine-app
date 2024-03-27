<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** Routes according to @link https://test15390.docs.apiary.io/#reference/0/report  */

Route::controller(CountryController::class)->group(function () {
    Route::get('/countries', 'index');
    Route::post('/country/{id}', 'store');
    Route::put('/country/{id}', 'show')->whereUuid('id');
    Route::delete('/country/{id}', 'destroy')->whereUuid('id');
});

Route::controller(CompanyController::class)->group(function () {
    Route::get('/companies', 'index');
    Route::post('/companies/{id}', 'store');
    Route::put('/companies/{id}', 'show')->whereUuid('id');
    Route::delete('/companies/{id}', 'destroy')->whereUuid('id');
});

Route::get('/report/{month}', function (Request $request) {
    //TODO: Generates report for a given month
})->whereNumber('month');


Route::get('/generate', function () {
    //TODO: Launch seeders here
});
