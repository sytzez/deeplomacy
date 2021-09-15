<?php

namespace App\Game\Validators;

use App\Game\Data\GiveActionPointsData;
use App\Game\Enums\Errors;
use App\Game\Services\GiveActionPointsService;
use App\Game\Services\VisibilityService;
use Exception;

class GiveActionPointsValidator
{
    protected GiveActionPointsData $data;

    public function __construct(
        protected GiveActionPointsService $giveActionPointsService,
        protected VisibilityService $visibilityService,
    ) {
    }

    /**
     * @param GiveActionPointsData $data
     * @throws Exception
     */
    public function validate(GiveActionPointsData $data): void
    {
        $this->data = $data;

        $this->checkValidRecipient();

        $this->checkRecipientVisibleByDonor();

        $this->checkSubmarinesWithinRange();

        $this->checkAmount();
    }

    /**
     * @throws Exception
     */
    protected function checkValidRecipient(): void
    {
        $donor = $this->data->getDonor();
        $recipient = $this->data->getRecipient();

        if ($donor->is($recipient)) {
            throw new Exception(Errors::CANNOT_TARGET_SELF);
        }

        if (! $donor->getGame()->is($recipient->getGame())) {
            throw new Exception(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws Exception
     */
    protected function checkRecipientVisibleByDonor(): void
    {
        if (! $this->visibilityService->canSeeSubmarine($this->data->getRecipient(), $this->data->getDonor())) {
            throw new Exception(Errors::TARGET_NOT_VISIBLE);
        }
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
        $actionPoints = $this->data->getActionPoints();

        if ($this->data->getActionPoints()->getAmount() < 1) {
            throw new Exception(Errors::AMOUNT_TOO_LOW);
        }

        if (
            ! $this->data->getDonor()
                ->getActionPoints()
                ->canAfford($actionPoints)
        ) {
            throw new Exception(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }
}
