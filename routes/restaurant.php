<?php

use App\Http\Controllers\Restaurant\AnalyticsController;
use App\Http\Controllers\Restaurant\CategoryController;
use App\Http\Controllers\Restaurant\DashboardController;
use App\Http\Controllers\Restaurant\FeedbackController;
use App\Http\Controllers\Restaurant\MenuItemController;
use App\Http\Controllers\Restaurant\OnboardingController;
use App\Http\Controllers\Restaurant\QrCodeController;
use App\Http\Controllers\Restaurant\RestaurantProfileController;
use App\Http\Controllers\Restaurant\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/onboarding', [OnboardingController::class, 'create'])->name('onboarding.create');
    Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
});

Route::middleware(['auth', 'verified', 'restaurant.onboarded'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::get('/profile', [RestaurantProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [RestaurantProfileController::class, 'update'])->name('profile.update');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');

    Route::get('/menu-items', [MenuItemController::class, 'index'])->name('menu-items.index');
    Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    Route::get('/menu-items/{menuItem}/edit', [MenuItemController::class, 'edit'])->name('menu-items.edit');
    Route::patch('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');
    Route::patch('/menu-items/{menuItem}/availability', [MenuItemController::class, 'toggleAvailability'])->name('menu-items.availability');

    Route::get('/qr-code', [QrCodeController::class, 'show'])->name('qr-code.show');
    Route::get('/qr-code/download', [QrCodeController::class, 'download'])->name('qr-code.download');

    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');

    Route::get('/subscription', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscription/select-package', [SubscriptionController::class, 'selectPackage'])->name('subscription.select-package');
    Route::post('/subscription/upload-payment', [SubscriptionController::class, 'uploadPayment'])->name('subscription.upload-payment');
    Route::get('/subscription/payments/{payment}/proof', [SubscriptionController::class, 'downloadProof'])->name('subscription.payments.proof');

    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});
