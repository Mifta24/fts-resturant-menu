<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicMenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/account', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/account', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/restaurant.php';
require __DIR__.'/admin.php';

Route::view('/blocked', 'blocked')->name('blocked');
Route::view('/terms', 'legal.terms')->name('terms');
Route::view('/privacy', 'legal.privacy')->name('privacy');

Route::get('/{restaurantSlug}', [PublicMenuController::class, 'show'])
    ->where('restaurantSlug', '[a-z0-9-]+')
    ->name('public-menu.show');
