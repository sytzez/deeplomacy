<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Data\MoveSubmarineData;
use App\Game\Data\Position;
use App\Http\Requests\MoveRequest;
use App\Models\Submarine;

class MoveSubmarineDataFactory
{
    public function make(Submarine $submarine, MoveRequest $request): MoveSubmarineData
    {
        $validated = $request->validated();

        $submarineAdapter = new SubmarineAdapter($submarine);

        $position = new Position(
            $validated['x'],
            $validated['y'],
        );

        return new MoveSubmarineData(
            $submarineAdapter,
            $submarineAdapter->getPosition()->getOffsetTo($position),
        );
    }
}
