<?php

use App\Http\Controllers\Manager\TrailerController;
use App\Http\Middleware\ManagerAuthenticate;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('trailers', [TrailerController::class, 'index'])->name('trailers.index');
    Route::get('trailers/create/{movie_id}', [TrailerController::class, 'create'])->name('trailers.create');
    Route::post('trailers', [TrailerController::class, 'store'])->name('trailers.store');
    Route::get('trailers/{id}/edit', [TrailerController::class, 'edit'])->name('trailers.edit');
    Route::put('trailers/{id}', [TrailerController::class, 'update'])->name('trailers.update');
    Route::delete('trailers/{id}', [TrailerController::class, 'destroy'])->name('trailers.destroy');
});