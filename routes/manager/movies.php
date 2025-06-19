<?php

use App\Http\Controllers\Manager\MovieController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ManagerAuthenticate;

Route::middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('manager/movies', [MovieController::class, 'index'])->name('movie.index');
    Route::get('manager/movies/create', [MovieController::class, 'create'])->name('movie.create');
    Route::post('manager/movies', [MovieController::class, 'store'])->name('movie.store');
    Route::get('manager/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movie.edit');
    Route::put('manager/movies/{movie}', [MovieController::class, 'update'])->name('movie.update');
    Route::delete('manager/movies/{movie}', [MovieController::class, 'destroy'])->name('movie.destroy');
    Route::get('manager/movies/{movie}', [MovieController::class, 'show'])->name('movie.show'); // هذا المسار لعرض تفاصيل الفيلم

    Route::get('manager/movie/statuses', [MovieController::class, 'statuses'])->name('manager.movie.statuses');
    Route::get('manager/movie/{movie}/edit-status', [MovieController::class, 'editStatus'])->name('movie.editStatus');
    Route::put('manager/movie/{movie}/update-status', [MovieController::class, 'updateStatus'])->name('movie.updateStatus');
});
