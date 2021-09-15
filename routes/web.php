<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayController;
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

Route::redirect('/', '/games');

Route::middleware('auth.auto')->group(function () {

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

    Route::resource('games', GameController::class)
        ->only(['index', 'create', 'store', 'show']);

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
