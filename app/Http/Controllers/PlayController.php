<?php

namespace App\Http\Controllers;

use App\Adapters\GameAdapter;
use App\Adapters\SubmarineAdapter;
use App\Game\Factories\GridFactory;
use App\Models\Game;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class PlayController
{
    public function show(Game $game, GameService $gameService, GridFactory $gridFactory): Renderable|RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $submarine = $gameService->getUserSubmarine($user, $game);

        if (! $submarine) {
            return Redirect::route('games.show', [$game]);
        }

        $grid = $gridFactory->make(
            new GameAdapter($game),
            new SubmarineAdapter($submarine),
        );

        return View::make('play.show')
            ->with([
                'grid' => $grid,
                'submarine' => $submarine
            ]);
    }
}
