<?php

namespace App\Http\ViewComposers;

use App\Contracts\ViewComposerContract;
use App\Models\Game;
use Illuminate\Contracts\View\View;

class GamesIndexComposer implements ViewComposerContract
{
    public function compose(View $view): void
    {
        $games = Game::query()
            ->whereHas('submarines');

        $view->with('games', $games);
    }
}
