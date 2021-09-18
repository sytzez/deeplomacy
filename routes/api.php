<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayController;
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

Route::apiResource('configurations', ConfigurationController::class)
    ->only(['index', 'show']);

Route::middleware('auth.auto')->group(function (): void {

    Route::name('games.')
        ->prefix('/games/{game}')
        ->group(function (): void {

            Route::name('join')
                ->get(
                    '/join',
                    [GameController::class, 'join']
                );

            Route::name('leave')
                ->get(
                    '/leave',
                    [GameController::class, 'leave']
                );
        });

    Route::apiResource('games', GameController::class)
        ->only(['index', 'store', 'show']);

    Route::name('play.')
        ->prefix('/play/{game}')
        ->group(function (): void {

            Route::name('show')
                ->get(
                    '/',
                    [PlayController::class, 'show']
                );

            Route::name('move')
                ->post(
                    '/move',
                    [PlayController::class, 'move']
                );

            Route::name('attack')
                ->post(
                    '/attack',
                    [PlayController::class, 'attack']
                );

            Route::name('give-action-points')
                ->post(
                    '/give-action-points',
                    [PlayController::class, 'giveActionPoints']
                );

            Route::name('share-sonar')
                ->post(
                    '/share-sonar',
                    [PlayController::class, 'shareSonar']
                );
        });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
