<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\PriceController;
use App\Http\Controllers\Api\InventoryController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login' , [AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('inventories', InventoryController::class)->only(['index', 'show', 'update']);
    Route::post('sales', [SaleController::class, 'createSale']);
    Route::post('get_price', [PriceController::class, 'calculate']);
});


