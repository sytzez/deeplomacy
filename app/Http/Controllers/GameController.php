<?php

namespace App\Http\Controllers;

use App\Factories\GameFactory;
use App\Http\Requests\StoreGameRequest;
use App\Models\Game;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

    public function store(StoreGameRequest $request, GameFactory $gameFactory): RedirectResponse
    {
        $game = $gameFactory->make($request);

        $game->save();

        return Redirect::route('games.show', [$game]);
    }

    public function show(Game $game): Renderable
    {
        return View::make('games.show')
            ->with('game', $game);
    }

    public function join(Game $game): RedirectResponse
    {
        return Redirect::route('games.show', [$game]);
    }
}
