<?php

use App\Http\Controllers\Auth\TelegramAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('guest')->group(function () {
    Route::get('/login/telegram/redirect', [TelegramAuthController::class, 'redirect'])->name('auth.telegram');
    Route::get('/login/telegram/callback', [TelegramAuthController::class, 'callback']);
});

Route::middleware(['auth', 'language', 'role:user|admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategoryController::class);
    Route::resource('criterias', CriteriaController::class);
    Route::resource('restaurants', RestaurantController::class);
    Route::resource('visits', VisitController::class)->except('create');
    Route::resource('groups', GroupController::class);

    Route::get('/restaurants/{id}/visits/create', [VisitController::class, 'create'])->name('visits.create');
    Route::get('/restaurants/{id}/visits', [VisitController::class, 'restaurant'])->name('visits.restaurant');

    Route::resource('users', UserController::class);
    Route::get('/users/{id}/groups', [UserController::class, 'editGroups'])->name('users.groups');
    Route::post('/users/{id}/groups', [UserController::class, 'updateGroups'])->name('users.update_groups');
    Route::get('/users/{id}/permissions', [UserController::class, 'editPermissions'])->name('users.permissions');
    Route::post('/users/{id}/permissions', [UserController::class, 'updatePermissions'])->name('users.update_permissions');
    Route::get('/users/{id}/roles', [UserController::class, 'editRoles'])->name('users.roles');
    Route::post('/users/{id}/roles', [UserController::class, 'updateRoles'])->name('users.update_roles');
    Route::get('/settings', [UserController::class, 'editSettings'])->name('users.settings');
    Route::post('/settings', [UserController::class, 'updateSettings'])->name('users.update_settings');
});
