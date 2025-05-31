<?php

use App\Http\Controllers\Auth\TelegramAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserProfileInfoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login/telegram/redirect', [TelegramAuthController::class, 'redirect'])->name('auth.telegram');
    Route::get('/login/telegram/callback', [TelegramAuthController::class, 'callback']);
});

Route::middleware(['auth', 'language', 'role:user|admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::middleware('can:view profiles')->resource('users', UserProfileController::class)->only('show');

    Route::resource('categories', CategoryController::class);

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/', [SettingsController::class, 'store'])->name('settings.store');
        Route::get('/information', [UserProfileInfoController::class, 'index'])->name('information.index');
        Route::post('/information', [UserProfileInfoController::class, 'store'])->name('information.store');
    });
});
