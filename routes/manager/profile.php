<?php

use App\Http\Controllers\manager\ManagerProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\ManagerAuthenticate;

Route::middleware([ManagerAuthenticate::class])->group(function () {

    Route::get('manager/profile/{id}', [ManagerProfileController::class, 'show'])->name('manager.profile');
    Route::get('manager/profile/{id}/edit', [ManagerProfileController::class, 'edit'])->name('manager.profile.edit');
    Route::put('manager/profile/{id}', [ManagerProfileController::class, 'update'])->name('manager.profile.update');
});
