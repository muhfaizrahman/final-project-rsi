<?php

use App\Http\Controllers\AddJobController;
use App\Http\Controllers\ApplyJobController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ChangeApplicationVisibilityController;
use App\Http\Controllers\CommentArticleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobSearchAndFilterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UpdateProfileApplicantController;
use App\Http\Controllers\UpdateProfileCompanyController;
use App\Http\Controllers\ViewApplicantCVController;
use App\Http\Controllers\ViewApplicantProfileController;
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
    
    // Use case view applicant profile
    Route::get('/profile/{user}', [ViewApplicantProfileController::class, 'index'])->name('profilePage');
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
});

// Company Routes
Route::middleware(['auth', 'role:perusahaan'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'index'])->name('companyDashboardPage');
    
    // Use case add a job application
    Route::get('/jobs/create', [AddJobController::class, 'indexCreate'])->name('createJobPage');
    Route::post('/jobs', [AddJobController::class, 'createJob'])->name('storeJob');

    // View applicants on a job
    Route::get('/jobs/{job}/applicants', [CompanyController::class, 'indexApplicants'])->name('companyApplicantsPage');

    // View applicant CV
    Route::get('/application/{application}/cv', [ViewApplicantCVController::class, 'index'])->name('viewApplicantCV');

    // Use case change job application visibility
    Route::put('/jobs/{job}/status', [ChangeApplicationVisibilityController::class, 'toggleStatus'])->name('toggleStatus');

    // Use case for company profile update
    Route::get('/company/profile/{user}', [UpdateProfileCompanyController::class, 'index'])->name('companyProfilePage');
    Route::get('/company/profile/{user}/edit', [UpdateProfileCompanyController::class, 'editCompany'])->name('editCompanyProfilePage');
    Route::put('/company/profile/{user}/update', [UpdateProfileCompanyController::class, 'updateCompany'])->name('updateCompanyProfile');
});