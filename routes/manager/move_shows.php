<?php

use App\Http\Controllers\manager\MovieShowController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('movie-shows', [MovieShowController::class, 'index'])->name('movie-shows.index');
    Route::get('movie-shows/create', [MovieShowController::class, 'create'])->name('movie-shows.create');
    Route::post('movie-shows', [MovieShowController::class, 'store'])->name('movie-shows.store');
    Route::get('movie-shows/{movieShow}', [MovieShowController::class, 'show'])->name('movie-shows.show');
    Route::get('movie-shows/{movieShow}/edit', [MovieShowController::class, 'edit'])->name('movie-shows.edit');
    Route::put('movie-shows/{movieShow}', [MovieShowController::class, 'update'])->name('movie-shows.update');
    Route::delete('movie-shows/{movieShow}', [MovieShowController::class, 'destroy'])->name('movie-shows.destroy');
    Route::post('/check-conflict', [MovieShowController::class, 'checkConflict'])->name('movie_shows.check_conflict');
    Route::get('/theaters/{theater}/screens', [MovieShowController::class, 'getScreens'])->name('movie_shows.get_screens');
});
