<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/', function () {
        return view('landing');
    });

});

Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('pages.home.index');
    })->middleware('verified')->name('homePage');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profile', function () {
        return view('pages.profile.index');
    })->name('profilePage');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('editProfilePage');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('updateProfile');


    Route::get('/artikel', function () {
        return view('pages.article.index');
    })->name('article');
    Route::get('/event', function () {
        return view('pages.event.index');
    })->name('event');
    Route::get('/bookmark', function () {
        return view('pages.bookmark.index');
    })->name('bookmark');
    Route::get('/chat', function () {
        return view('pages.chat.index');
    })->name('chat');

});