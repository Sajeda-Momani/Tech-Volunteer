<?php

use App\Http\Controllers\Admin_Auth\AdminAuthenticatedSessionController;
use App\Http\Controllers\Admin_Auth\AdminConfirmablePasswordController;
use App\Http\Controllers\Admin_Auth\AdminEmailVerificationNotificationController;
use App\Http\Controllers\Admin_Auth\AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin_Auth\AdminNewPasswordController;
use App\Http\Controllers\Admin_Auth\AdminPasswordController;
use App\Http\Controllers\Admin_Auth\AdminPasswordResetLinkController;
use App\Http\Controllers\Admin_Auth\AdminRegisteredUserController;
use App\Http\Controllers\Admin_Auth\AdminVerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [AdminRegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [AdminRegisteredUserController::class, 'store']);

    Route::get('login', [AdminAuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AdminAuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [AdminPasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [AdminPasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [AdminNewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [AdminNewPasswordController::class, 'store'])
                ->name('password.store');

// // display the pages of project

    Route::view('/loadmins/login', 'loadmins.login');
//     Route::view('pages/about', 'pages/about');
//     Route::view('pages/contact', 'pages/contact');
//     Route::view('pages/causes', 'pages/causes');
//     Route::view('pages/news', 'pages.news');

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email',AdminEmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', AdminVerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [AdminConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    // Route::post('confirm-password', [AdminConfirmablePasswordController::class, 'store']);

    Route::put('password', [AdminPasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AdminAuthenticatedSessionController::class, 'destroy'])
                ->name('logout');


    // display the pages of project

    

    // Route::view('pages/index', 'pages/index');
    // Route::view('pages/about', 'pages/about');
    // Route::view('pages/contact', 'pages/contact');
    // Route::view('pages/causes', 'pages/causes');
    // Route::view('pages/news', 'pages.news');


});
