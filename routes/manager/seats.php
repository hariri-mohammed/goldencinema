<?php

use App\Http\Controllers\Manager\SeatController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('/theaters/{theater}/screens/{screen}/seats', [SeatController::class, 'index'])
        ->name('theaters.screens.seats.index');

    Route::get('/theaters/{theater}/screens/{screen}/seats/create', [SeatController::class, 'create'])
        ->name('theaters.screens.seats.create');

    Route::post('/theaters/{theater}/screens/{screen}/seats', [SeatController::class, 'store'])
        ->name('theaters.screens.seats.store');

    Route::get('/theaters/{theater}/screens/{screen}/seats/edit', [SeatController::class, 'edit'])
        ->name('theaters.screens.seats.edit');

    Route::put('/theaters/{theater}/screens/{screen}/seats', [SeatController::class, 'update'])
        ->name('theaters.screens.seats.update');

    Route::put('/theaters/{theater}/screens/{screen}/seats/bulk', [SeatController::class, 'bulkUpdate'])
        ->name('theaters.screens.seats.bulk-update');

    Route::delete('/theaters/{theater}/screens/{screen}/seats/delete-all', [SeatController::class, 'deleteAll'])
        ->name('theaters.screens.seats.deleteAll');

    Route::put('/theaters/{theater}/screens/{screen}/seats/{seat}', [SeatController::class, 'updateSingle'])
        ->name('theaters.screens.seats.updateSingle');
});
