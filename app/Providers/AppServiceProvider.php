<?php

namespace App\Providers;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Repositories\SubmarineRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SubmarineRepositoryContract::class, SubmarineRepository::class);
    }
}
