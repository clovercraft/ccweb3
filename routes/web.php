<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(PageController::class)
    ->name('page.')
    ->group(function () {
        // public routes
        Route::get('/', 'index')->name('home');
        Route::get('registration', 'registration')->name('registration');
        Route::get('minecraft-server', 'smp')->name('smp');
        Route::get('our-community', 'community')->name('community');

        // member routes
        Route::middleware('auth')
            ->group(function () {
                Route::get('profile', 'profile')->name('profile');
                Route::get('member/{user}', 'profile')->name('member');
            });
    });

Route::controller(AuthController::class)
    ->name('auth.')
    ->prefix('auth')
    ->group(function () {
        Route::get('/login', 'sendToDiscord')->name('login');
        Route::get('/redirect', 'redirect')->name('redirect');
        Route::get('/logout', 'logout')->name('logout');
    });

Route::controller(AdminController::class)
    ->middleware('auth')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('/settings', 'settings')->name('settings');
        Route::post('/settings', 'updateSettings')->name('updateSettings');

        Route::prefix('members')
            ->name('members.')
            ->group(function () {
                Route::get('/', 'members')->name('list');
                Route::get('/approveWhitelist/{user}', 'approveWhitelist')->name('approveWhitelist');
                Route::get('/removeWhitelist/{user}', 'removeWhitelist')->name('removeWhitelist');
                Route::get('/ban/{user}', 'ban')->name('ban');
                Route::get('/setRole/{user}/{role}', 'setUserRole')->name('setRole');
            });
    });
