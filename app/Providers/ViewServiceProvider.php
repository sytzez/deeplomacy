<?php

namespace App\Providers;


use App\Http\ViewComposers\GamesCreateComposer;
use App\Http\ViewComposers\GamesIndexComposer;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('games.index', GamesIndexComposer::class);
        View::composer('games.create', GamesCreateComposer::class);
    }
}
