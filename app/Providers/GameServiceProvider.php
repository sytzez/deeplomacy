<?php

namespace App\Providers;

use App\Game\Actions\AttackSubmarineAction;
use App\Game\Actions\GiveActionPointsAction;
use App\Game\Actions\MoveSubmarineAction;
use App\Game\Actions\JoinSubmarineAction;
use App\Game\Actions\ShareSonarAction;
use App\Game\Services\AttackSubmarineService;
use App\Game\Services\GiveActionPointsService;
use App\Game\Services\MoveSubmarineService;
use App\Game\Services\ShareSonarService;
use App\Game\Services\SubmarineService;
use App\Game\Services\VisibilityService;
use App\Game\Validators\AttackSubmarineValidator;
use App\Game\Validators\GiveActionPointsValidator;
use App\Game\Validators\MoveSubmarineValidator;
use App\Game\Validators\ShareSonarValidator;
use Illuminate\Support\ServiceProvider;

class GameServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SubmarineService::class);

        $this->app->singleton(VisibilityService::class);

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

        $this->app->singleton(JoinSubmarineAction::class);
    }
}
