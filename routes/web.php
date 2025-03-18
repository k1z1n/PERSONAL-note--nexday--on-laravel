<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompletedTasksController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('view.register');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/email/verify', [AuthController::class, 'showEmailVerify'])
    ->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/resend', [AuthController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:1,1'])
    ->name('verification.send');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('view.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Маршруты, требующие подтвержденного аккаунта:
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return view('pages.main');
    })->name('view.home');

    Route::get('/completed-tasks', [CompletedTasksController::class, 'index'])->name('view.completed.tasks');
});

// Добавляем маршрут для выхода (logout)
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::post('/send-test-email', [AuthController::class, 'sendTestEmail'])->name('test.email');
