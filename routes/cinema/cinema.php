<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CinemaController;
use App\Http\Controllers\BookingController;

Route::prefix('Goldencinema')->group(function () {
    Route::get('/', [CinemaController::class, 'index'])->name('movies.index');
    Route::get('/movies/{id}', [CinemaController::class, 'show'])->name('movies.show');
    Route::get('/category/{id}', [CinemaController::class, 'filterByCategory'])->name('movies.by.category');
});
