<?php

use App\Http\Controllers\client\auth\LoginController;
use App\Http\Controllers\client\auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:client')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('client.login');
    Route::post('login', [LoginController::class, 'store']);
    Route::get('register', [RegisterController::class, 'create'])->name('client.register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::middleware('auth:client')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('client.logout');
}); 