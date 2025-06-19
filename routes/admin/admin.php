<?php

use App\Http\Controllers\admin\auth\AdminLoginController;
use App\Http\Middleware\AdminAuthenticate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'create'])->name('admin_login');
    Route::post('/login', [AdminLoginController::class, 'store'])->name('admin_login_post');
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('admin_logout');
});


Route::middleware([AdminAuthenticate::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin_login');
        }
        $admin = Auth::guard('admin')->user();
        return view('admin.Admin_dashboard', compact('admin'));
    })->name('admin_dashboard');

    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('admin.dashboard');
});
