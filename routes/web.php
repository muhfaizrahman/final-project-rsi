<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])
    ->middleware(['throttle:6,1'])
    ->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->middleware('verified')->name('homePage');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});