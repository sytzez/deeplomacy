<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use Game\Data\MoveSubmarineData;
use Game\Data\Position;
use App\Http\Requests\MoveSubmarineRequest;
use App\Models\Submarine;

class MoveSubmarineDataFactory
{
    public function make(Submarine $submarine, MoveSubmarineRequest $request): MoveSubmarineData
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
