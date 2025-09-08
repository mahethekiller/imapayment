<?php

use App\Http\Controllers\Landing\MemberAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PaymentController;

Route::get('/', function(){ return redirect()->route('lp.show','consumption-report'); });

// Route::get('/landing/{slug}', [LandingPageController::class, 'show'])->name('landing.show');
// Route::post('/landing/{slug}/register', [RegistrationController::class, 'store'])->name('registration.store');

// Route::get('/payment/checkout/{registration}', [PaymentController::class, 'checkout'])->name('payment.checkout');
// Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
// Route::get('/payment/success/{registration}', [PaymentController::class, 'success'])->name('payment.success');
// Route::get('/payment/failed/{registration}', [PaymentController::class, 'failed'])->name('payment.failed');


Route::get('/lp/{slug}/choose', [LandingPageController::class, 'chooseType'])->name('landing.choose');

// Route::get('/landing/{slug}/register', [LandingPageController::class, 'registerForm'])->name('landing.register');

Route::get('/lp/{slug}', [LandingPageController::class, 'show'])->name('lp.show');
// Payment/registration
Route::get('/lp/{slug}/register', [LandingPageController::class, 'register'])->name('landing.register');

Route::post('/lp/{slug}/payment/start', [PaymentController::class, 'start'])->name('payment.start');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::post('lp/{slug}/summary', [RegistrationController::class, 'summary'])->name('landing.summary');
// Route::post('landing/{slug}/pay', [RegistrationController::class, 'start'])->name('payment.start');





Route::get('/lp/{slug}/member-login', [MemberAuthController::class, 'showLoginForm'])->name('landing.member.login');
Route::post('/lp/{slug}/member-login', [MemberAuthController::class, 'login'])->name('landing.member.login.post');
Route::post('/lp/logout', [MemberAuthController::class, 'logout'])->name('landing.member.logout');

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
