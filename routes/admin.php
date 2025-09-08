<?php

use App\Http\Controllers\Admin\DiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LandingPageController as AdminLanding;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrations;
use App\Http\Controllers\Admin\RegistrationController;

Route::middleware(['auth','role:admin|editor'])->prefix('admin')->group(function(){
    Route::resource('landing-pages', AdminLanding::class);
    Route::get('landing-pages/{id}/registrations/export', [AdminRegistrations::class, 'export'])->name('admin.landing.registrations.export');
    Route::resource('landing-pages.registrations', AdminRegistrations::class)->only(['index','show','destroy']);

    // Registrations
    Route::resource('registrations', RegistrationController::class)->only(['index','show'])->names(['index' => 'admin.registrations.index', 'show' => 'admin.registrations.show']);
    Route::get('landing-pages/{id}/registrations', [AdminLanding::class, 'registrations'])->name('admin.landing.registrations');
    Route::get('landing-pages/{id}/registrations/export', [AdminLanding::class, 'exportRegistrations'])->name('admin.landing.export');

    // Discounts
    Route::resource('discounts', DiscountController::class);

    // Payments
    Route::resource('payments', AdminPaymentController::class)->only(['index','show']);
});

// Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){
//     Route::resource('landing-pages', AdminLanding::class);
//     Route::get('landing-pages/{id}/registrations', [AdminLanding::class, 'registrations'])->name('admin.landing.registrations');
//     Route::get('landing-pages/{id}/registrations/export', [AdminLanding::class, 'exportRegistrations'])->name('admin.landing.export');
// });


Route::middleware(['auth', 'role:admin|editor'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard2');
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');


});




