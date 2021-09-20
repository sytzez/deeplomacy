<?php

namespace App\Http\Controllers;

use App\Adapters\GameAdapter;
use App\Adapters\SubmarineAdapter;
use App\Factories\AttackSubmarineDataFactory;
use App\Factories\GiveActionPointsDataFactory;
use App\Factories\MoveSubmarineDataFactory;
use App\Factories\ShareSonarDataFactory;
use App\Game\Actions\AttackSubmarineAction;
use App\Game\Actions\GiveActionPointsAction;
use App\Game\Actions\MoveSubmarineAction;
use App\Game\Actions\ShareSonarAction;
use App\Game\Data\GameActionException;
use App\Game\Factories\GridFactory;
use App\Http\Requests\AttackSubmarineRequest;
use App\Http\Requests\GiveActionPointsRequest;
use App\Http\Requests\MoveSubmarineRequest;
use App\Http\Requests\ShareSonarRequest;
use App\Http\Resources\GridResource;
use App\Http\Resources\MySubmarineResource;
use App\Models\Game;
use App\Models\Submarine;
use App\Models\User;
use App\Services\GameService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class PlayController
{
    public function __construct(
        protected GameService $gameService,
        protected GridFactory $gridFactory,
    ) {
    }

    public function show(Game $game, GridFactory $gridFactory): Responsable|JsonResponse
    {
        if (! ($submarine = $this->getSubmarine($game))) {
            return Response::json([
                'message' => 'not_joined'
            ], 403);
        }

        return $this->createGameStatusResponse($game, $submarine);
    }

    public function move(
        Game $game,
        MoveSubmarineRequest $request,
        MoveSubmarineDataFactory $dataFactory,
        MoveSubmarineAction $action,
    ): Responsable|JsonResponse {
        return $this->doGameAction($game, $request, $dataFactory, $action);
    }

    public function attack(
        Game $game,
        AttackSubmarineRequest $request,
        AttackSubmarineDataFactory $dataFactory,
        AttackSubmarineAction $action,
    ): Responsable|JsonResponse {
        return $this->doGameAction($game, $request, $dataFactory, $action);
    }

    public function giveActionPoints(
        Game $game,
        GiveActionPointsRequest $request,
        GiveActionPointsDataFactory $dataFactory,
        GiveActionPointsAction $action,
    ): Responsable|JsonResponse {
        return $this->doGameAction($game, $request, $dataFactory, $action);
    }

    public function shareSonar(
        Game $game,
        ShareSonarRequest $request,
        ShareSonarDataFactory $dataFactory,
        ShareSonarAction $action,
    ): Responsable|JsonResponse {
        return $this->doGameAction($game, $request, $dataFactory, $action);
    }

    protected function doGameAction(Game $game, FormRequest $request, $dataFactory, $action): Responsable|JsonResponse
    {
        $submarine = $this->getSubmarine($game);

        if (! $submarine) {
            return Response::json([
               'message' => 'not_joined',
            ], 403);
        }

        try {
            $data = $dataFactory->make($submarine, $request);

            $message = $action->do($data);

        } catch (GameActionException $e) {
            return $this->createGameStatusResponse($game, $submarine, $e->getMessage());
        }

        return $this->createGameStatusResponse($game, $submarine, $message);
    }

    protected function createGameStatusResponse(
        Game $game,
        Submarine $submarine,
        ?string $message = null,
    ): JsonResponse {
        $grid = $this->gridFactory->make(
            new GameAdapter($game),
            new SubmarineAdapter($submarine),
        );

        return Response::json([
            'data' => [
                'grid'        => new GridResource($grid),
                'mySubmarine' => new MySubmarineResource($submarine),
                'message'     => $message,
            ],
        ]);
    }

    protected function getSubmarine(Game $game): ?Submarine
    {
        /** @var User $user */
        $user = Auth::user();

        return $this->gameService->getUserSubmarine($user, $game);
    }
}
