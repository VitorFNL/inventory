<?php

use App\Http\Controllers\ShowLoginPageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use Illuminate\Support\Facades\Route;

// Rota raiz redireciona para login
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', ShowLoginPageController::class)->name('login');
Route::post('/login', LoginController::class)->name('login.post');
Route::post('/logout', LogoutController::class)->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return '<h1>Dashboard - Bem-vindo!</h1><form method="POST" action="/logout">'.csrf_field().'<button type="submit">Logout</button></form>';
    })->name('dashboard');
});
