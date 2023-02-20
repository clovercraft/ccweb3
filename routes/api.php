<?php

use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\RegistrationController;
use App\Http\Controllers\API\SettlementController;
use App\Http\Controllers\API\WhitelistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RegistrationController::class)
    ->prefix('registration')
    ->group(function () {
        Route::post('minecraft', 'validateMinecraft');
        Route::post('verification', 'verification');
    });

Route::controller(MemberController::class)
    ->prefix('member')
    ->name('api.member.')
    ->middleware('can:update,user')
    ->group(function () {
        Route::get('activateWhitelst/{user}', 'activateWhitelist')->name('activateWhitelist');
        Route::get('deactivateWhitelist/{user}', 'deactivateWhitelist')->name('deactivateWhitelist');
        Route::get('ban/{user}', 'ban')->name('ban');
    });

Route::controller(WhitelistController::class)
    ->prefix('whitelist')
    ->middleware('smp')
    ->group(function () {
        Route::get('updates', 'getWhitelistUpdate');
        Route::get('all', 'getFullWhitelist');
    });

Route::controller(SettlementController::class)
    ->prefix('settlements')
    ->name('settlements.')
    ->middleware('smp')
    ->group(function () {
        Route::get('list', 'list')->name('list');
        Route::get('create', 'create')->name('create');
        Route::get('join', 'join')->name('join');
    });
