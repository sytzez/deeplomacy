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

        $this->checkRecipientVisibleByDonor();

        $this->checkSubmarinesWithinRange();
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
