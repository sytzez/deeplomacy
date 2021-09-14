<?php

namespace App\Http\Controllers;

use App\Factories\GameFactory;
use App\Factories\SubmarineFactory;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class GameController extends Controller
{
    public function index(): Renderable
    {
        return View::make('games.index');
    }

    public function create(): Renderable
    {
        return View::make('games.create');
    }

    public function store(
        StoreGameRequest $request,
        GameFactory $gameFactory,
        GameService $gameService
    ): RedirectResponse {
        $game = $gameFactory->make($request);

        $game->save();

        /** @var User $user */
        $user = Auth::user();

        $gameService->join($user, $game);

        return Redirect::route('games.show', [$game]);
    }

    public function show(Game $game): Renderable
    {
        return View::make('games.show')
            ->with('game', $game);
    }

    public function join(Game $game, GameService $gameService): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $gameService->join($user, $game);

        return Redirect::route('games.show', [$game]);
    }

    public function leave(Game $game, GameService $gameService): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $gameService->leave($user, $game);

        return Redirect::route('games.show', [$game]);
    }
}
