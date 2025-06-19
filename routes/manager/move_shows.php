<?php

use App\Http\Controllers\Manager\MovieShowController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('manager/movie-shows', [MovieShowController::class, 'index'])->name('manager.movie-shows.index');
    Route::get('manager/movie-shows/create', [MovieShowController::class, 'create'])->name('manager.movie-shows.create');
    Route::post('manager/movie-shows', [MovieShowController::class, 'store'])->name('manager.movie-shows.store');
    Route::get('manager/movie-shows/{movieShow}/edit', [MovieShowController::class, 'edit'])->name('manager.movie-shows.edit');
    Route::put('manager/movie-shows/{movieShow}', [MovieShowController::class, 'update'])->name('manager.movie-shows.update');
    Route::delete('manager/movie-shows/{movieShow}', [MovieShowController::class, 'destroy'])->name('manager.movie-shows.destroy');
    Route::get('manager/movie-shows/{movieShow}', [MovieShowController::class, 'show'])->name('manager.movie-shows.show');
    Route::post('/check-conflict', [MovieShowController::class, 'checkConflict'])->name('movie_shows.check_conflict');
    Route::get('/theaters/{theater}/screens', [MovieShowController::class, 'getScreens'])->name('movie_shows.get_screens');
});
