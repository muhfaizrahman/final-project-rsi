<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileCompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Guest Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('registerPage');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::get('/login', [LoginController::class, 'index'])->name('loginPage');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    
    Route::get('/', function () {
        return redirect('/login');
    });
});

// Email Verification Routes
Route::get('/email/verify', [RegisterController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', [RegisterController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');

// Authenticated Routes
Route::middleware(['auth'])->group(callback: function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/profile/{user}', [ProfileController::class, 'showProfilePage'])->name('profilePage');
});

// Applicant Routes
Route::middleware(['auth', 'role:pelamar'])->group(function () {
    Route::get('/home', [JobController::class, 'index'])->middleware('verified')->name('homePage');

    // Profile Routes
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('editProfilePage');
    Route::put('/profile/{user}/update', [ProfileController::class, 'update'])->name('updateProfile');

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
    Route::put('/messages/{message}', [ChatController::class, 'update'])->name('updateMessage');
    Route::delete('/messages/{message}', [ChatController::class, 'delete'])->name('deleteMessage');

    // Event Routes
    Route::get('/event', [EventController::class, 'index'])->name('eventPage');
    Route::get('/event/{event}/detail', [EventController::class, 'indexDetail'])->name('eventDetailPage');
    Route::get('/event/{event}/register', [EventController::class, 'createRegistration'])->name('eventFormPage');
    Route::post('/event/{event}/register', [EventController::class, 'storeRegistration'])->name('storeEventRegistration');

    // Article Routes
    Route::get('/artikel', [ArticleController::class, 'index'])->name('articlePage');
    Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('showArticle');
    Route::post('/artikel/{article:slug}/comments', [CommentController::class, 'store'])->name('storeComment');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('updateComment');
    Route::delete('/comments/{comment}', [CommentController::class, 'delete'])->name('deleteComment');
});

// Company Routes
Route::middleware(['auth', 'role:perusahaan'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'index'])->name('companyDashboardPage');
    
    Route::get('/jobs/create', [CompanyController::class, 'indexCreate'])->name('createJobPage');
    Route::post('/jobs', [CompanyController::class, 'createJob'])->name('storeJob');

    Route::get('/jobs/{job}/applicants', [CompanyController::class, 'indexApplicants'])->name('companyApplicantsPage');

    Route::put('/jobs/{job}/status', [CompanyController::class, 'toggleStatus'])->name('toggleStatus');

    Route::get('/company/profile/{user}', [ProfileCompanyController::class, 'showProfilePage'])->name('companyProfilePage');
    Route::get('/company/profile/{user}/edit', [ProfileCompanyController::class, 'editCompany'])->name('editCompanyProfilePage');
    Route::put('/company/profile/{user}/update', [ProfileCompanyController::class, 'updateCompany'])->name('updateCompanyProfile');
});