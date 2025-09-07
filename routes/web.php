<?php

use App\Http\Controllers\ListProductsController;
use App\Http\Controllers\ShowLoginPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

// Rota raiz redireciona para login
Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', ShowLoginPageController::class)->name('login');

    Route::post('/login', LoginController::class)->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

});
Route::get('/dashboard', ListProductsController::class)->name('dashboard');
