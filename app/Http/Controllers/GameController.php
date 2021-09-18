<?php

namespace App\Http\Controllers;

use App\Factories\GameFactory;
use App\Http\Requests\StoreGameRequest;
use App\Http\Resources\GameResource;
use App\Models\Game;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    public function index(): Responsable
    {
        return GameResource::collection(
            Game::query()
                ->withCount('submarines')
                ->having('submarines_count', '>', 0)
                ->get()
        );
    }

    public function store(
        StoreGameRequest $request,
        GameFactory $gameFactory,
        GameService $gameService
    ): Responsable {
        $game = $gameFactory->make($request);

        $game->save();

        /** @var User $user */
        $user = Auth::user();

        $gameService->join($user, $game);

        return new GameResource($game);
    }

    public function show(Game $game): Responsable
    {
        return new GameResource($game);
    }

    public function join(Game $game, GameService $gameService): Responsable
    {
        /** @var User $user */
        $user = Auth::user();

        $gameService->join($user, $game);

        return new GameResource($game);
    }

    public function leave(Game $game, GameService $gameService): Responsable
    {
        /** @var User $user */
        $user = Auth::user();

        $gameService->leave($user, $game);

        return new GameResource($game);
    }
}
