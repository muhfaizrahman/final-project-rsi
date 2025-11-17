<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['guest'])->group(function () {
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('registerPage');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/', [AuthController::class, 'showLoginForm']);

});

Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [JobController::class, 'index'])->middleware('verified')->name('homePage');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'showProfilePage'])->name('profilePage');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('editProfilePage');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('updateProfile');

    // Apply Routes
    Route::get('/apply/{job}', [ApplicationController::class, 'showApplicationForm'])->name('applicationFormPage');
    Route::post('/apply/{job}', [ApplicationController::class, 'store'])->name('submitApplication');

    // Bookmark Routes
    Route::get('/bookmark', [BookmarkController::class, 'index'])->name('showBookmarkPage');
    Route::post('/job/{job}/toggle', [BookmarkController::class, 'toggle'])->name('toggleBookmark');

    // Chat Routes
    Route::get('/chats', [ChatController::class, 'index'])->name('chatsPage');
    Route::get('/chats/{thread}', [ChatController::class, 'show'])->name('showDetailChat'); 
    Route::get('/chats/job/{job}', [ChatController::class, 'createOrShow'])->name('createOrShowChat');
    Route::post('/chats/{thread}/send', [ChatController::class, 'sendMessage'])->name('sendChat');

    // Event Routes
    Route::get('/event', [EventController::class, 'index'])->name('eventPage');
    Route::get('/{event}/detail', [EventController::class, 'indexDetail'])->name('eventDetailPage');
    Route::get('/{event}/register', [EventController::class, 'createRegistration'])->name('eventFormPage');
    Route::post('/{event}/register', [EventController::class, 'storeRegistration'])->name('storeEventRegistration');

    // Article Routes
    Route::get('/artikel', function () {
        return view('pages.article.index');
    })->name('article');
});