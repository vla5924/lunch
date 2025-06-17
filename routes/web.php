<?php

use App\Http\Controllers\Auth\TelegramAuthController;
use App\Http\Controllers\Auth\YandexAuthController;
use App\Http\Controllers\BannedRestaurantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('guest')->group(function () {
    Route::get('/login/telegram/redirect', [TelegramAuthController::class, 'redirect'])->name('auth.telegram');
    Route::get('/login/telegram/callback', [TelegramAuthController::class, 'callback']);
});

Route::get('/login/yandex/redirect', [YandexAuthController::class, 'redirect'])->name('auth.yandex');
Route::get('/login/yandex/callback', [YandexAuthController::class, 'callback']);

Route::middleware(['auth', 'language', 'role:user|admin'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::resource('categories', CategoryController::class);
    Route::resource('criterias', CriteriaController::class);
    Route::resource('restaurants', RestaurantController::class);
    Route::resource('visits', VisitController::class)->except('create');
    Route::resource('groups', GroupController::class);
    Route::resource('comments', CommentController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('evaluations', EvaluationController::class)->except(['index', 'create']);

    Route::get('/restaurants/{id}/visits/create', [VisitController::class, 'create'])->name('visits.create');
    Route::get('/restaurants/{id}/visits', [VisitController::class, 'restaurant'])->name('visits.restaurant');
    Route::get('/restaurants/{id}/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::get('/restaurants/{id}/evaluations', [EvaluationController::class, 'restaurant'])->name('evaluations.restaurant');
    Route::post('/restaurants/ban', [BannedRestaurantController::class, 'ban'])->name('restaurants.ban');
    Route::post('/restaurants/unban', [BannedRestaurantController::class, 'unban'])->name('restaurants.unban');

    Route::resource('users', UserController::class);
    Route::get('/users/{id}/groups', [UserAdminController::class, 'groups'])->name('users.groups');
    Route::post('/users/{id}/groups', [UserAdminController::class, 'updateGroups']);
    Route::get('/users/{id}/permissions', [UserAdminController::class, 'permissions'])->name('users.permissions');
    Route::post('/users/{id}/permissions', [UserAdminController::class, 'updatePermissions']);
    Route::get('/users/{id}/roles', [UserAdminController::class, 'roles'])->name('users.roles');
    Route::post('/users/{id}/roles', [UserAdminController::class, 'updateRoles']);
    Route::get('/settings', [UserSettingsController::class, 'edit'])->name('users.settings');
    Route::post('/settings', [UserSettingsController::class, 'update']);
    Route::post('/settings/remove_yandex_id', [UserSettingsController::class, 'removeYandexId'])->name('users.setings.remove_yandex_id');
});
