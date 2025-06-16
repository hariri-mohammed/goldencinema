<?php

use App\Http\Controllers\Manager\ScreenController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('/theaters/{theater}/screens', [ScreenController::class, 'index'])
        ->name('theaters.screens.index');

    Route::get('/theaters/{theater}/screens/create', [ScreenController::class, 'create'])
        ->name('theaters.screens.create');

    Route::post('/theaters/{theater}/screens', [ScreenController::class, 'store'])
        ->name('theaters.screens.store');

    Route::get('/theaters/{theater}/screens/{screen}/edit', [ScreenController::class, 'edit'])
        ->name('theaters.screens.edit');

    Route::put('/theaters/{theater}/screens/{screen}', [ScreenController::class, 'update'])
        ->name('theaters.screens.update');

    Route::delete('/theaters/{theater}/screens/{screen}', [ScreenController::class, 'destroy'])
        ->name('theaters.screens.destroy');
});
