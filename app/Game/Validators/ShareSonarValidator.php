<?php

namespace App\Game\Validators;

use App\Game\Data\ShareSonarData;
use App\Game\Enums\Errors;
use App\Game\Services\ShareSonarService;
use App\Game\Services\VisibilityService;
use Exception;

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
     * @throws Exception
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
     * @throws Exception
     */
    protected function checkValidRecipient(): void
    {
        $donor     = $this->data->getDonor();
        $recipient = $this->data->getRecipient();

        if ($donor->is($recipient)) {
            throw new Exception(Errors::CANNOT_TARGET_SELF);
        }

        if (!$donor->getGame()->is($recipient->getGame())) {
            throw new Exception(Errors::TARGET_NOT_IN_GAME);
        }
    }

    /**
     * @throws Exception
     */
    protected function checkSufficientActionPoints(): void
    {
        $actionPointsRequired = $this->shareSonarService->getActionPointsRequired($this->data);

        if ($this->data->getDonor()->getActionPoints() < $actionPointsRequired) {
            throw new Exception(Errors::INSUFFICIENT_ACTION_POINTS);
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
        if (! $this->shareSonarService->areSubmarinesWithinRange($this->data)) {
            throw new Exception(Errors::TARGET_TOO_FAR_AWAY);
        };
    }
}
