<?php

namespace App\Http\ViewComposers;

use App\Contracts\ViewComposerContract;
use App\Models\Configuration;
use Illuminate\Contracts\View\View;

class GamesCreateComposer implements ViewComposerContract
{
    public function compose(View $view): void
    {
        $configurations = Configuration::all();

        $view->with('configurations', $configurations);
    }
}
