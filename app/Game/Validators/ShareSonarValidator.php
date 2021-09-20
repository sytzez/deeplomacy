<?php

namespace App\Game\Validators;

use App\Game\Data\GameActionException;
use App\Game\Data\ShareSonarData;
use App\Game\Enums\Errors;
use App\Game\Services\ShareSonarService;
use App\Game\Services\VisibilityService;

class ShareSonarValidator
{
    protected ShareSonarData $data;

    public function __construct(
        protected ShareSonarService $shareSonarService,
        protected VisibilityService $visibilityService,
    ) {
    }

    /**
     * @param ShareSonarData $data
     * @throws GameActionException
     */
    public function validate(ShareSonarData $data): void
    {
        $this->data = $data;

        $this->checkValidRecipient();

        $this->checkSufficientActionPoints();

        $this->checkRecipientVisibleByDonor();

        $this->checkSubmarinesWithinRange();
    }

    /**
     * @throws GameActionException
     */
    protected function checkValidRecipient(): void
    {
        $donor     = $this->data->getDonor();
        $recipient = $this->data->getRecipient();

        if ($donor->is($recipient)) {
            throw new GameActionException(Errors::CANNOT_TARGET_SELF);
        }

        if (!$donor->getGame()->is($recipient->getGame())) {
            throw new GameActionException(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->shareSonarService->getActionPointsRequired($this->data);

        if (
            ! $this->data->getDonor()
                ->getActionPoints()
                ->canAfford($actionPointsRequired)
        ) {
            throw new GameActionException(Errors::INSUFFICIENT_ACTION_POINTS);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkRecipientVisibleByDonor(): void
    {
        if (
            ! $this->visibilityService->canSeeSubmarine(
                $this->data->getRecipient(),
                $this->data->getDonor()
            )
        ) {
            throw new GameActionException(Errors::TARGET_NOT_VISIBLE);
        }
    }

    /**
     * @throws GameActionException
     */
    protected function checkSubmarinesWithinRange(): void
    {
        if (! $this->shareSonarService->areSubmarinesWithinRange($this->data)) {
            throw new GameActionException(Errors::TARGET_TOO_FAR_AWAY);
        };
    }
}
