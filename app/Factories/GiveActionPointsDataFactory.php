<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Data\ActionPoints;
use App\Game\Data\GiveActionPointsData;
use App\Http\Requests\GiveActionPointsRequest;
use App\Models\Submarine;
use Exception;

class GiveActionPointsDataFactory
{
    /**
     * @param Submarine $donor
     * @param GiveActionPointsRequest $request
     * @return GiveActionPointsData
     * @throws Exception
     */
    public function make(Submarine $donor, GiveActionPointsRequest $request): GiveActionPointsData
    {
        $validated = $request->validated();

        /** @var Submarine $recipient */
        $recipient = Submarine::query()
            ->find($validated['submarine']);

        return new GiveActionPointsData(
            new SubmarineAdapter($donor),
            new SubmarineAdapter($recipient),
            new ActionPoints($validated['amount']),
        );
    }
}
