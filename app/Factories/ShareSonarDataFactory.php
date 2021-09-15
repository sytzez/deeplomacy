<?php

namespace App\Factories;

use App\Adapters\SubmarineAdapter;
use App\Game\Data\ShareSonarData;
use App\Http\Requests\ShareSonarRequest;
use App\Models\Submarine;
use Exception;

class ShareSonarDataFactory
{
    /**
     * @param Submarine $donor
     * @param ShareSonarRequest $request
     * @return ShareSonarData
     * @throws Exception
     */
    public function make(Submarine $donor, ShareSonarRequest $request): ShareSonarData
    {
        $validated = $request->validated();

        /** @var Submarine $recipient */
        $recipient = Submarine::query()
            ->find($validated['submarine']);

        return new ShareSonarData(
            new SubmarineAdapter($donor),
            new SubmarineAdapter($recipient),
        );
    }
}
