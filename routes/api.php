<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CountryController;
use App\Models\Country;
use App\Services\ServiceReportCompanies;
use App\Services\ServiceReportCountries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Database\Seeders\CountrySeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\CheatSeeder;
use Database\Seeders\MiningSeeder;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/** Routes according to @link https://test15390.docs.apiary.io/#reference/0/report */

Route::controller(CountryController::class)->group(function () {
    Route::get('/countries', 'index');
    Route::get('/country/{uuid}', 'show')->whereUuid('uuid');
    Route::post('/country', 'store');
    Route::put('/country/{uuid}', 'update')->whereUuid('uuid');
    Route::delete('/country/{uuid}', 'destroy')->whereUuid('uuid');
});

Route::controller(CompanyController::class)->group(function () {
    Route::get('/companies', 'index');
    Route::get('/company/{uuid}', 'show')->whereUuid('uuid');
    Route::post('/companies', 'store');
    Route::put('/companies/{uuid}', 'update')->whereUuid('uuid');
    Route::delete('/companies/{uuid}', 'destroy')->whereUuid('uuid');
});

Route::get('/report_countries/{month}', function ($month) {
    return (new ServiceReportCountries)->handle($month);
})->whereNumber('month');

Route::get('/report_companies/{month}', function ($month) {
    return (new ServiceReportCompanies)->handle($month);
})->whereNumber('month');

Route::get('/generate', function () {
    //Correct order of seeders
    $seeders = [
        'Database\Seeders\CountrySeeder',
        'Database\Seeders\CompanySeeder',
        'Database\Seeders\CheatSeeder',
        'Database\Seeders\MiningSeeder'
    ];

    foreach ($seeders as $seeder) {
        (new $seeder)->run();
    }
});

Route::get('/clear', function () {
    DB::table('minings')->truncate();
    DB::table('companies')->truncate();
    Country::query()->truncate();
});
