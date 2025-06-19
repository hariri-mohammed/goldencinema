<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Public Booking Routes (require authentication)
Route::get('/movie-shows/{movie_show}/book', [BookingController::class, 'create'])
    ->middleware('auth:client')
    ->name('booking.create'); 