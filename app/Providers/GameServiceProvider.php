<?php

namespace App\Providers;

use App\Game\Actions\MoveSubmarineAction;
use App\Game\Services\GiveActionPointsService;
use App\Game\Services\MoveSubmarineService;
use App\Game\Services\VisibilityService;
use App\Game\Validators\GiveActionPointsValidator;
use App\Game\Validators\MoveSubmarineValidator;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MoveSubmarineService::class);
        $this->app->singleton(MoveSubmarineValidator::class);
        $this->app->singleton(MoveSubmarineAction::class);

        $this->app->singleton(GiveActionPointsService::class);
        $this->app->singleton(GiveActionPointsValidator::class);

        $this->app->singleton(VisibilityService::class);
    }
}
