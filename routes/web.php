<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return "صفحة التسجيل قيد الإنشاء - قريباً!";
})->name('register');

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/settings', [App\Http\Controllers\Admin\PlatformSettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [App\Http\Controllers\Admin\PlatformSettingsController::class, 'update'])->name('admin.settings.update');

    Route::get('/packages', function () {
        return view('admin.packages');
    })->name('admin.packages');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('admin.users');

    Route::get('/withdrawals', function () {
        return view('admin.withdrawals');
    })->name('admin.withdrawals');

    Route::get('/reports', function () {
        return view('admin.reports');
    })->name('admin.reports');
});
