<?php

use App\Http\Controllers\Manager\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::middleware([ManagerAuthenticate::class])->group(function () {
    Route::get('manager/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('manager/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('manager/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('manager/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('manager/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('manager/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::get('manager/categories/{category}/movies', [CategoryController::class, 'movies'])->name('categories.movies');
});
