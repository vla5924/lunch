<?php

use App\Http\Controllers\Auth\TelegramAuthController;
use App\Http\Controllers\Auth\YandexAuthController;
use App\Http\Controllers\BannedRestaurantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\TelegramBotController;
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
    Route::resource('comments', CommentController::class)->only(['store', 'edit', 'update', 'destroy']);
    Route::resource('evaluations', EvaluationController::class)->except(['index', 'create']);
    Route::resource('events', EventController::class);

    Route::get('/restaurants/{id}/visits/create', [VisitController::class, 'create'])->name('visits.create');
    Route::get('/restaurants/{id}/visits', [VisitController::class, 'restaurant'])->name('visits.restaurant');
    Route::get('/restaurants/{id}/evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create');
    Route::get('/restaurants/{id}/evaluations', [EvaluationController::class, 'restaurant'])->name('evaluations.restaurant');
    Route::post('/restaurants/ban', [BannedRestaurantController::class, 'ban'])->name('restaurants.ban');
    Route::post('/restaurants/unban', [BannedRestaurantController::class, 'unban'])->name('restaurants.unban');

    Route::get('/categories/{id}/rating', [CategoryController::class, 'rating'])->name('categories.rating');

    Route::get('/visits/{id}/participate', [VisitController::class, 'participate'])->name('visits.participate');
    Route::post('/visits/cancel_participation', [VisitController::class, 'cancelParticipation'])->name('visits.cancel_participation');

    Route::resource('users', UserController::class);
    Route::get('/users/{id}/permissions', [UserAdminController::class, 'permissions'])->name('users.permissions');
    Route::post('/users/{id}/permissions', [UserAdminController::class, 'updatePermissions']);
    Route::get('/users/{id}/roles', [UserAdminController::class, 'roles'])->name('users.roles');
    Route::post('/users/{id}/roles', [UserAdminController::class, 'updateRoles']);

    Route::get('/settings', [UserSettingsController::class, 'edit'])->name('users.settings');
    Route::post('/settings/app', [UserSettingsController::class, 'updateApp'])->name('users.settings.app');
    Route::post('/settings/notification', [UserSettingsController::class, 'updateNotification'])->name('users.settings.notification');
    Route::post('/settings/remove_yandex_id', [UserSettingsController::class, 'removeYandexId'])->name('users.setings.remove_yandex_id');
});

Route::prefix('/telegram')->group(function () {
    Route::get('/setup', [TelegramBotController::class, 'setup'])->name('telegram.setup');
    Route::get('/info', [TelegramBotController::class, 'info'])->name('telegram.info');
    Route::get('/webhook', [TelegramBotController::class, 'stub'])->name('telegram.stub');
    Route::post('/webhook', [TelegramBotController::class, 'webhook'])->name('telegram.webhook');
});
