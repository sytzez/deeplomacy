<?php

namespace App\Providers;

use App\Game\Actions\MoveSubmarineAction;
use App\Game\Services\MoveSubmarineService;
use App\Game\Validators\MoveSubmarineValidator;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MoveSubmarineService::class);
        $this->app->singleton(MoveSubmarineValidator::class);
        $this->app->singleton(MoveSubmarineAction::class);
    }
}
