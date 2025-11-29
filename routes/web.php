<?php

use App\Http\Controllers\ApplyJobController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CommentArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSearchAndFilterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileCompanyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UpdateProfileApplicantController;
use App\Http\Controllers\ViewArticle;
use App\Http\Controllers\ViewArticleController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::middleware(['guest'])->group(function () {
    // Use case register
    Route::get('/register', [RegisterController::class, 'index'])->name('registerPage');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    
    // Use case login
    Route::get('/login', [LoginController::class, 'index'])->name('loginPage');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    
    Route::get('/', function () {
        return redirect('/login');
    });
});

// Email Verification Routes // Use case register
Route::get('/email/verify', [RegisterController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');
Route::post('/email/verification-notification', [RegisterController::class, 'resendVerificationEmail'])->middleware(['throttle:6,1'])->name('verification.send');

// Authenticated Routes
Route::middleware(['auth'])->group(callback: function () {
    // Use case logout
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    
    // Use case update profile for applicant 
    Route::get('/profile/{user}', [UpdateProfileApplicantController::class, 'index'])->name('profilePage');
});

// Applicant Routes
Route::middleware(['auth', 'role:pelamar'])->group(function () {
    Route::get('/home', [JobSearchAndFilterController::class, 'index'])->middleware('verified')->name('homePage');

    // Use case update profile for applicant
    Route::get('/profile/{user}/edit', [UpdateProfileApplicantController::class, 'edit'])->name('editProfilePage');
    Route::put('/profile/{user}/update', [UpdateProfileApplicantController::class, 'update'])->name('updateProfile');

    // Use case apply for a job
    Route::get('/apply/{job}', [ApplyJobController::class, 'index'])->name('applicationFormPage');
    Route::post('/apply/{job}', [ApplyJobController::class, 'store'])->name('submitApplication');

    // Use case bookmark a job
    Route::get('/bookmark', [BookmarkController::class, 'index'])->name('showBookmarkPage');
    Route::post('/job/{job}/toggle', [BookmarkController::class, 'toggle'])->name('toggleBookmark');
    
    // Use case for view an article
    Route::get('/artikel', [ViewArticleController::class, 'index'])->name('articlePage');
    Route::get('/artikel/{article:slug}', [ViewArticleController::class, 'show'])->name('showArticle');

    // Use case for comment on an article
    Route::post('/artikel/{article:slug}/comments', [CommentArticleController::class, 'store'])->name('storeComment');
    Route::put('/comments/{comment}', [CommentArticleController::class, 'update'])->name('updateComment');
    Route::delete('/comments/{comment}', [CommentArticleController::class, 'delete'])->name('deleteComment');
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