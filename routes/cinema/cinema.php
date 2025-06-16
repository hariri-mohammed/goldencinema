<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\BookingController;


use App\Http\Controllers\client\auth\ClientAuthController;
use App\Http\Controllers\client\ClientProfileController;

Route::get('/login', [ClientAuthController::class, 'showLoginForm'])->name('Client_login');
Route::post('/login', [ClientAuthController::class, 'login']);
Route::post('/logout', [ClientAuthController::class, 'logout'])->name('Client_logout');
Route::get('/client_register', [ClientAuthController::class, 'showRegisterForm'])->name('client_register');
Route::post('/client_register', [ClientAuthController::class, 'register']);

Route::get('/client_profile', [ClientProfileController::class, 'show_profile'])
    ->middleware('auth:client')
    ->name('client_profile');

Route::middleware(['auth:client'])->group(function () {
    Route::get('/profile', [ClientProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('/profile', [ClientProfileController::class, 'update'])->name('client.profile.update');
});

Route::prefix('Goldencinema')->group(function () {
    Route::get('/', [CinemaController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [CinemaController::class, 'show'])->name('movies.show');
    Route::get('/category/{id}', [CinemaController::class, 'filterByCategory'])->name('movies.by.category');
});

Route::get('/booking/{show_id}', [BookingController::class, 'create'])->name('booking.create');
