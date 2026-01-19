<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockScreenController;
use App\Http\Controllers\MailerController;
use Illuminate\Support\Facades\Mail;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');

//Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');

//Reset Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('/send-reset-link', [AuthController::class, 'sendResetLink'])->name('sendResetLink');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('passwordReset');
Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('updatePassword');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/lock', [LockScreenController::class, 'lock'])->name('lock');
    Route::get('/lock-screen', [LockScreenController::class, 'show'])->name('lock.screen');
    Route::post('/unlock', [LockScreenController::class, 'unlock'])->name('unlock');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
