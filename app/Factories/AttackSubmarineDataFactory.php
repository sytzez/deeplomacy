<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Data\AttackSubmarineData;
use App\Http\Requests\AttackSubmarineRequest;
use App\Models\Submarine;
use Exception;

class AttackSubmarineDataFactory
{
    /**
     * @param Submarine $attacker
     * @param AttackSubmarineRequest $request
     * @return AttackSubmarineData
     * @throws Exception
     */
    public function make(Submarine $attacker, AttackSubmarineRequest $request): AttackSubmarineData
    {
        $validated = $request->validated();

        /** @var Submarine $target */
        $target = Submarine::query()
            ->find($validated['submarine']);

        return new AttackSubmarineData(
            new SubmarineAdapter($attacker),
            new SubmarineAdapter($target),
        );
    }
}
