<?php

use App\Http\Controllers\admin\AdminProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminAuthenticate;

Route::prefix('admin')->middleware([AdminAuthenticate::class])->group(function () {
    Route::get('/profile/{id}', [AdminProfileController::class, 'show'])->name('admin.profile');
    Route::get('/profile/{id}/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/profile/{id}', [AdminProfileController::class, 'update'])->name('admin.profile.update');
});
