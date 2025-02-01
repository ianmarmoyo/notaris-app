<?php

use App\Http\Controllers\Api\CourrierController;
use App\Http\Controllers\Api\Region\DistrictController;
use App\Http\Controllers\Api\Region\ProvinceController;
use App\Http\Controllers\Api\Region\RegencieController;
use App\Http\Controllers\Api\Region\VillageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


# PROVINCE
Route::group(['prefix' => 'province', 'as' => 'province-'], function () {
    Route::get('/', [ProvinceController::class, 'index'])->name('index');
    Route::get('/select', [ProvinceController::class, 'select'])->name('select');
});

Route::group(['prefix' => 'regencie', 'as' => 'regencie-'], function () {
    Route::get('/', [RegencieController::class, 'index'])->name('index');
    Route::get('/select', [RegencieController::class, 'select'])->name('select');
});

Route::group(['prefix' => 'district', 'as' => 'district-'], function () {
    Route::get('/', [DistrictController::class, 'index'])->name('index');
    Route::get('/select', [DistrictController::class, 'select'])->name('select');
});

Route::group(['prefix' => 'village', 'as' => 'village-'], function () {
    Route::get('/', [VillageController::class, 'index'])->name('index');
    Route::get('/select', [VillageController::class, 'select'])->name('select');
});

Route::group(['prefix' => 'courier', 'as' => 'courier-'], function () {
    Route::get('/select', [CourrierController::class, 'select'])->name('select');
    Route::get('/select_with_rate', [CourrierController::class, 'select_with_rate'])->name('select_with_rate');
});
