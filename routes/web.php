<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\PlayController;
use Illuminate\Support\Facades\Route;

Route::any('/{any}', function() {
    return view('main');
})->where('any', '^(?!api).*$');

Route::redirect('/', '/games');

Route::middleware('auth.auto')->group(function () {

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
