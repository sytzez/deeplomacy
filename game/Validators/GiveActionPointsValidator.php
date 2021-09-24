<?php

namespace Game\Validators;

use Game\Data\GameActionException;
use Game\Data\GiveActionPointsData;
use Game\Enums\Errors;
use Game\Services\GiveActionPointsService;
use Game\Services\VisibilityService;

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
     * @throws GameActionException
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
     * @throws GameActionException
     */
    protected function checkValidRecipient(): void
    {
        $donor = $this->data->getDonor();
        $recipient = $this->data->getRecipient();

        if ($donor->is($recipient)) {
            throw new GameActionException(Errors::CANNOT_TARGET_SELF);
        }

        if (! $donor->getGame()->is($recipient->getGame())) {
            throw new GameActionException(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkRecipientVisibleByDonor(): void
    {
        if (! $this->visibilityService->canSeeSubmarine($this->data->getRecipient(), $this->data->getDonor())) {
            throw new GameActionException(Errors::TARGET_NOT_VISIBLE);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkSubmarinesWithinRange(): void
    {
        if (! $this->giveActionPointsService->areSubmarinesWithinRange($this->data)) {
            throw new GameActionException(Errors::TARGET_TOO_FAR_AWAY);
        };
    }

    /**
     * @throws GameActionException
     */
    protected function checkAmount(): void
    {
        $actionPoints = $this->data->getActionPoints();

        if ($this->data->getActionPoints()->getAmount() < 1) {
            throw new GameActionException(Errors::AMOUNT_TOO_LOW);
        }

        if (
            ! $this->data->getDonor()
                ->getActionPoints()
                ->canAfford($actionPoints)
        ) {
            throw new GameActionException(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }
}
