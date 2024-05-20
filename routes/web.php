<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountSelectionController;
use App\Http\Controllers\RegistrationController;
use App\Models\Account;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Middleware\VerifyForgotPassword;
use App\Http\Middleware\Photographer;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\PhotographerController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ActiveContractsController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/accountselection', [AccountSelectionController::class, 'show'])->name('account.selection');


Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrationController::class, 'register'])->name('register');


Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');


Route::middleware([VerifyForgotPassword::class])->group(function () {
    Route::get('/update-password', [UpdatePasswordController::class, 'showUpdatePasswordForm'])->name('update-password');
    Route::post('/update-password', [UpdatePasswordController::class, 'updatePassword'])->name('update-password.post');
});

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/myprofile', [MyProfileController::class, 'showProfile'])->name('myprofile');
    Route::post('/update-profile-photo', [MyProfileController::class, 'updateProfilePhoto'])->name('update.profile.photo');
});

Route::put('/profile/update', [MyProfileController::class, 'updateProfile'])->name('profile.update');

// Route::get('/photographers', [PhotographerController::class, 'index'])->name('photographers');
// Route::post('/send-offer/{photographer_id}', [PhotographerController::class, 'sendOffer'])->name('send.offer');

// Route::middleware(['auth', CheckPhotographer::class])->group(function () {
//     Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
//     Route::post('/offers.accept/{id}', [OfferController::class, 'acceptOffer'])->name('offers.accept');
//     Route::post('/offers.ignore/{id}', [OfferController::class, 'ignoreOffer'])->name('offers.ignore');
// });

Route::get('/photographers', [PhotographerController::class, 'index'])->name('photographers.index');

Route::middleware(['auth'])->group(function () {
    Route::post('/send-offer/{photographer_id}', [PhotographerController::class, 'sendOffer'])->name('send.offer');
});


Route::middleware('auth')->group(function () {
    Route::get('/offers', [OfferController::class, 'index'])->name('offers.index');
    Route::post('/offers/accept', [OfferController::class, 'acceptOffer'])->name('offers.accept');
    Route::post('/offers/ignore', [OfferController::class, 'ignoreOffer'])->name('offers.ignore');
});

Route::middleware('auth')->group(function () {
    Route::get('/active-contracts', [ActiveContractsController::class, 'index'])->name('active-contracts.index');
    
    Route::post('/active-contracts/cancel', [ActiveContractsController::class, 'cancel'])
        ->name('active-contracts.cancel')
        ->middleware('isPhotographer'); // Only photographers can cancel contracts

    Route::post('/active-contracts/end', [ActiveContractsController::class, 'end'])
        ->name('active-contracts.end')
        ->middleware('isClient'); // Only clients can end contracts
});