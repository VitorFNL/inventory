<?php

use App\Http\Controllers\SyncProductsController;
use App\Http\Controllers\UpdateProductController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'products'], function () {
    Route::put('/{id}', UpdateProductController::class)->middleware('auth')->name('products.update');

    Route::post('/sync', SyncProductsController::class)->middleware('auth')->name('products.sync');
});
