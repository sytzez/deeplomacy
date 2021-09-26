<?php

use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::name('token')
    ->get(
        '/token',
        [TokenController::class, 'show']
    );

Route::apiResource('configurations', ConfigurationController::class)
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function (): void {

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

            Route::name('show-if-needed')
                ->get(
                    '/',
                    [PlayController::class, 'showIfNeeded']
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
