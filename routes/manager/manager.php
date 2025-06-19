<?php

use App\Http\Controllers\manager\auth\LoginController;
use App\Http\Middleware\ManagerAuthenticate;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('manager.login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::post('/logout', [LoginController::class, 'destroy'])->name('managerlogout');

    Route::middleware([ManagerAuthenticate::class])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Manager\DashboardController::class, 'index'])->name('managerdashboard');
    });
});
