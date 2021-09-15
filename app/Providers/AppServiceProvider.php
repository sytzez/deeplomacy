<?php

namespace App\Providers;

use App\Game\Contracts\RngServiceContract;
use App\Game\Contracts\SubmarineRepositoryContract;
use App\Repositories\SubmarineRepository;
use App\Services\RngService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SubmarineRepositoryContract::class, SubmarineRepository::class);

        $this->app->singleton(RngServiceContract::class, RngService::class);
    }
}
