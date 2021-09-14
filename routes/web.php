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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth.auto')->group(function () {

    Route::name('games.join')
        ->get('games/{game}/join', [GameController::class, 'join']);

    Route::name('games.leave')
        ->get('games/{game}/leave', [GameController::class, 'leave']);

    Route::resource('games', GameController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::name('play.show')
        ->get('play/{game}', [PlayController::class, 'show']);

    Route::name('play.move')
        ->post('play/{game}/move', [PlayController::class, 'move']);
});
