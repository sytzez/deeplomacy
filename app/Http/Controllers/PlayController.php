<?php

namespace App\Http\Controllers;

use App\Adapters\GameAdapter;
use App\Adapters\SubmarineAdapter;
use App\Factories\GiveActionPointsDataFactory;
use App\Factories\MoveSubmarineDataFactory;
use App\Factories\ShareSonarDataFactory;
use App\Game\Actions\GiveActionPointsAction;
use App\Game\Actions\MoveSubmarineAction;
use App\Game\Actions\ShareSonarAction;
use App\Game\Factories\GridFactory;
use App\Http\Requests\GiveActionPointsRequest;
use App\Http\Requests\MoveSubmarineRequest;
use App\Http\Requests\ShareSonarRequest;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use App\Services\GameService;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class PlayController
{
    public function __construct(
        protected GameService $gameService,
    ) {
    }

    public function show(Game $game, GridFactory $gridFactory): Renderable|RedirectResponse
    {
        if (! ($submarine = $this->getSubmarine($game))) {
            return Redirect::route('games.show', [$game]);
        }

        $grid = $gridFactory->make(
            new GameAdapter($game),
            new SubmarineAdapter($submarine),
        );

        return View::make('play.show')
            ->with([
                'game' => $game,
                'grid' => $grid,
                'submarine' => $submarine
            ]);
    }

    public function move(
        Game $game,
        MoveSubmarineRequest $request,
        MoveSubmarineDataFactory $dataFactory,
        MoveSubmarineAction $action,
    ): RedirectResponse {
        if (! ($submarine = $this->getSubmarine($game))) {
            return Redirect::route('games.show', [$game]);
        }

        try{
            $data = $dataFactory->make($submarine, $request);

            $action->do($data);
        } catch (Exception $e) {
            return Redirect::route('play.show', [$game])
                ->withException($e);
        }

        return Redirect::route('play.show', [$game]);
    }

    public function giveActionPoints(
        Game $game,
        GiveActionPointsRequest $request,
        GiveActionPointsDataFactory $dataFactory,
        GiveActionPointsAction $action,
    ): RedirectResponse {
        if (! ($submarine = $this->getSubmarine($game))) {
            return Redirect::route('games.show', [$game]);
        }

        try{
            $data = $dataFactory->make($submarine, $request);

            $action->do($data);

        } catch (Exception $e) {
            return Redirect::route('play.show', [$game])
                ->withException($e);
        }

        return Redirect::route('play.show', [$game]);
    }

    public function shareSonar(
        Game $game,
        ShareSonarRequest $request,
        ShareSonarDataFactory $dataFactory,
        ShareSonarAction $action,
    ): RedirectResponse {
        if (! ($submarine = $this->getSubmarine($game))) {
            return Redirect::route('games.show', [$game]);
        }

        try{
            $data = $dataFactory->make($submarine, $request);

            $action->do($data);

        } catch (Exception $e) {
            return Redirect::route('play.show', [$game])
                ->withException($e);
        }

        return Redirect::route('play.show', [$game]);
    }

    protected function getSubmarine(Game $game): Submarine
    {
        /** @var User $user */
        $user = Auth::user();

        return $this->gameService->getUserSubmarine($user, $game);
    }
}
