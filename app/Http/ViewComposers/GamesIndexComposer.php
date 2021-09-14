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
            ->withCount('submarines')
            ->having('submarines_count', '>', 0)
            ->get();

        $view->with('games', $games);
    }
}
