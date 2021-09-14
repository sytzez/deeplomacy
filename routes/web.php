<?php

use App\Http\Controllers\GameController;
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

    Route::name('games.play')
        ->get('games/{game}/play', [GameController::class, 'play']);

    Route::resource('games', GameController::class)
        ->only(['index', 'create', 'store', 'show']);
});
