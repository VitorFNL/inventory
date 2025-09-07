<?php

use App\Http\Controllers\UpdateProductController;
use Illuminate\Support\Facades\Route;

Route::put('/products/{id}', UpdateProductController::class);