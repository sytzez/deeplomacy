<?php

use Illuminate\Support\Facades\Route;

Route::any('/{any}', function() {
    return view('main');
})->where('any', '^(?!api).*$');
