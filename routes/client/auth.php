<?php

use App\Http\Controllers\client\Auth\ClientAuthController;
use App\Http\Controllers\Client\ClientProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:client')->group(function () {
    Route::get('client/login', [ClientAuthController::class, 'showLoginForm'])->name('client.login');
    Route::post('client/login', [ClientAuthController::class, 'login'])->name('client.login.store');
    Route::get('client/register', [ClientAuthController::class, 'showRegistrationForm'])->name('client.register');
    Route::post('client/register', [ClientAuthController::class, 'register'])->name('client.register.store');
});

Route::middleware('auth:client')->group(function () {
    Route::post('client/logout', [ClientAuthController::class, 'logout'])->name('client.logout');
    Route::get('profile', [ClientProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('profile', [ClientProfileController::class, 'update'])->name('client.profile.update');
    Route::put('profile/password', [ClientProfileController::class, 'updatePassword'])->name('profile.password');
}); 