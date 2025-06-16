<?php
// routes/manager/theaters.php

use App\Http\Controllers\Manager\TheaterController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ManagerAuthenticate;

Route::prefix('manager')->name('manager.')->middleware([ManagerAuthenticate::class])->group(function () {
    // عرض قائمة المسارح
    Route::get('/theaters', [TheaterController::class, 'index'])
        ->name('theaters.index');

    // عرض نموذج إضافة مسرح جديد
    Route::get('/theaters/create', [TheaterController::class, 'create'])
        ->name('theaters.create');

    // حفظ مسرح جديد
    Route::post('/theaters', [TheaterController::class, 'store'])
        ->name('theaters.store');

    // عرض نموذج تعديل مسرح
    Route::get('/theaters/{theater}/edit', [TheaterController::class, 'edit'])
        ->name('theaters.edit');

    // تحديث بيانات مسرح
    Route::put('/theaters/{theater}', [TheaterController::class, 'update'])
        ->name('theaters.update');

    // حذف مسرح
    Route::delete('/theaters/{theater}', [TheaterController::class, 'destroy'])
        ->name('theaters.destroy');

    // عرض تفاصيل المسرح والشاشات التابعة له
    Route::get('/theaters/{theater}', [TheaterController::class, 'show'])
        ->name('theaters.show');

    // إدارة الشاشات التابعة للمسرح
    Route::get('/theaters/{theater}/screens', [TheaterController::class, 'screens'])
        ->name('theaters.screens');
});
