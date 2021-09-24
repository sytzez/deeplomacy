<?php

namespace App\Providers;

use Game\Actions\AttackSubmarineAction;
use Game\Actions\GiveActionPointsAction;
use Game\Actions\MoveSubmarineAction;
use Game\Actions\JoinGameAction;
use Game\Actions\ShareSonarAction;
use Game\Factories\GridFactory;
use Game\Services\AttackSubmarineService;
use Game\Services\GiveActionPointsService;
use Game\Services\MoveSubmarineService;
use Game\Services\ShareSonarService;
use Game\Services\SubmarineService;
use Game\Services\VisibilityService;
use Game\Validators\AttackSubmarineValidator;
use Game\Validators\GiveActionPointsValidator;
use Game\Validators\MoveSubmarineValidator;
use Game\Validators\ShareSonarValidator;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SubmarineService::class);

        $this->app->singleton(VisibilityService::class);

        $this->app->singleton(GridFactory::class);

        $this->app->singleton(MoveSubmarineService::class);
        $this->app->singleton(MoveSubmarineValidator::class);
        $this->app->singleton(MoveSubmarineAction::class);

        $this->app->singleton(GiveActionPointsService::class);
        $this->app->singleton(GiveActionPointsValidator::class);
        $this->app->singleton(GiveActionPointsAction::class);

        $this->app->singleton(ShareSonarService::class);
        $this->app->singleton(ShareSonarValidator::class);
        $this->app->singleton(ShareSonarAction::class);

        $this->app->singleton(AttackSubmarineService::class);
        $this->app->singleton(AttackSubmarineValidator::class);
        $this->app->singleton(AttackSubmarineAction::class);

        $this->app->singleton(JoinGameAction::class);
    }
}
