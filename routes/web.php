<?php

use App\Http\Controllers\manager\MovieController;
use App\Http\Controllers\manager\TrailerController;
use App\Http\Controllers\manager\auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use Faker\Guesser\Name;
use App\Http\Middleware\ManagerAuthenticate;

use App\Http\Controllers\manager\ManagerProfileController;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\manager\MovieShowController;
use App\Http\Controllers\BookingController;

//admin routes
require __DIR__ . '/auth.php';
require __DIR__ . '/admin/admin.php';
require __DIR__ . '/admin/admin_profile.php';
require __DIR__ . '/admin/managers.php';

//manager routes
require __DIR__ . '/manager/manager.php';
require __DIR__ . '/manager/categores.php';
require __DIR__ . '/manager/movies.php';
require __DIR__ . '/manager/move_shows.php';
require __DIR__ . '/manager/profile.php';
require __DIR__ . '/manager/theaters.php';
require __DIR__ . '/manager/screens.php';
require __DIR__ . '/manager/seats.php';
require __DIR__ . '/cinema/cinema.php';

// Trailer Routes
Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('trailers', [TrailerController::class, 'index'])->name('trailers.index');
    Route::get('trailers/create/{movie_id}', [TrailerController::class, 'create'])->name('trailers.create');
    Route::post('trailers', [TrailerController::class, 'store'])->name('trailers.store');
    Route::get('trailers/{id}/edit', [TrailerController::class, 'edit'])->name('trailers.edit');
    Route::put('trailers/{id}', [TrailerController::class, 'update'])->name('trailers.update');
    Route::delete('trailers/{id}', [TrailerController::class, 'destroy'])->name('trailers.destroy');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test', function () {
    return view('layouts.visetor_sit_');
});
Route::get('/test2', function () {
    return view('testt');
});

// Client Routes
require __DIR__ . '/client/auth.php';

Route::middleware(['auth:client'])->prefix('client')->name('client.')->group(function () {
    // Booking Routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [BookingController::class, 'showBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/pay', [BookingController::class, 'processPayment'])->name('bookings.pay');
    Route::delete('/bookings/{booking}', [BookingController::class, 'cancel'])->name('bookings.cancel');
});

// Public Booking Routes
Route::get('/movie-shows/{movie_show}/book', [BookingController::class, 'create'])
    ->middleware('auth:client')
    ->name('booking.create');
Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store');
