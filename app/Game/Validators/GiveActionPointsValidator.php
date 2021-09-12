<?php

namespace App\Game\Validators;

use App\Game\Contracts\SubmarineRepositoryContract;
use App\Game\Data\GiveActionPointsData;
use App\Game\Enums\Errors;
use App\Game\Services\GiveActionPointsService;
use Exception;

class GiveActionPointsValidator
{
    protected GiveActionPointsData $data;

    public function __construct(
        protected SubmarineRepositoryContract $submarineRepository,
        protected GiveActionPointsService $giveActionPointsService,
    ) {
    }

    /**
     * @param GiveActionPointsData $data
     * @throws Exception
     */
    public function validate(GiveActionPointsData $data): void
    {
        $this->data = $data;

        $this->checkSubmarinesWithinRange();

        $this->checkAmount();
    }

    /**
     * @throws Exception
     */
    protected function checkSubmarinesWithinRange(): void
    {
        if (! $this->giveActionPointsService->areSubmarinesWithinRange($this->data)) {
            throw new Exception(Errors::TARGET_TOO_FAR_AWAY);
        };
    }

    /**
     * @throws Exception
     */
    protected function checkAmount(): void
    {
        if ($this->data->getAmount() < 1) {
            throw new Exception(Errors::AMOUNT_TOO_LOW);
        }

        if ($this->data->getAmount() > $this->data->getDonor()->getActionPoints()) {
            throw new Exception(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }
}
