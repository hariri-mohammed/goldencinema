<?php

use App\Http\Controllers\admin\AdminManagerController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthenticate;

Route::prefix('admin')->middleware([AdminAuthenticate::class])->group(function () {
    Route::get('/managers', [AdminManagerController::class, 'index'])->name('admin.managers.index');
    Route::get('/managers/create', [AdminManagerController::class, 'create'])->name('admin.managers.create');
    Route::post('/managers', [AdminManagerController::class, 'store'])->name('admin.managers.store');
    Route::get('/managers/{manager}', [AdminManagerController::class, 'show'])->name('admin.managers.show');
    Route::get('/managers/{manager}/edit', [AdminManagerController::class, 'edit'])->name('admin.managers.edit');
    Route::put('/managers/{manager}', [AdminManagerController::class, 'update'])->name('admin.managers.update');
    Route::delete('/managers/{manager}', [AdminManagerController::class, 'destroy'])->name('admin.managers.destroy');
});
