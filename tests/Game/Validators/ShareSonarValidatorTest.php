<?php

namespace Tests\Game\Validators;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\ActionPoints;
use Game\Data\ShareSonarData;
use Game\Enums\Errors;
use Game\Services\ShareSonarService;
use Game\Services\VisibilityService;
use Game\Validators\ShareSonarValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class ShareSonarValidatorTest extends TestCase
{
    protected Mockery\LegacyMockInterface|ShareSonarService|Mockery\MockInterface $shareSonarServiceMock;
    protected Mockery\LegacyMockInterface|VisibilityService|Mockery\MockInterface $visibilityServiceMock;

    protected ShareSonarValidator $validator;

    protected GameContract|Mockery\LegacyMockInterface|Mockery\MockInterface $gameMock;

    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $donorActionPointsMock;
    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $actionPointsRequiredMock;

    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $donorMock;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $recipientMock;

    protected ShareSonarData|Mockery\LegacyMockInterface|Mockery\MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->shareSonarServiceMock = Mockery::mock(ShareSonarService::class);
        $this->visibilityServiceMock = Mockery::mock(VisibilityService::class);

        $this->validator = new ShareSonarValidator(
            $this->shareSonarServiceMock,
            $this->visibilityServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->donorActionPointsMock = Mockery::mock(ActionPoints::class);
        $this->actionPointsRequiredMock = Mockery::mock(ActionPoints::class);

        $this->donorMock = Mockery::mock(SubmarineContract::class, [
            'getGame'         => $this->gameMock,
            'getActionPoints' => $this->donorActionPointsMock,
        ]);

        $this->recipientMock = Mockery::mock(SubmarineContract::class, [
            'getGame' => $this->gameMock,
        ]);

        $this->dataMock = Mockery::mock(ShareSonarData::class, [
            'getDonor'        => $this->donorMock,
            'getRecipient'    => $this->recipientMock,
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_recipient_is_the_donor(): void
    {
        $this->allowAllChecksButNot('recipient is donor');

        $this->recipientMock->expects('is')
            ->with($this->donorMock)
            ->once()
            ->andReturnTrue();

        static::expectExceptionMessage(Errors::CANNOT_TARGET_SELF);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_recipient_is_in_another_game(): void
    {
        $this->allowAllChecksButNot('recipient in same game');

        $this->gameMock->expects('is')
            ->with($this->gameMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::TARGET_NOT_IN_GAME);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_donor_cannot_afford_the_amount(): void
    {
        $this->allowAllChecksButNot('action points required');

        $this->shareSonarServiceMock->expects('getActionPointsRequired')
            ->with($this->dataMock)
            ->once()
            ->andReturn($this->actionPointsRequiredMock);

        $this->donorActionPointsMock->expects('canAfford')
            ->with($this->actionPointsRequiredMock)
            ->once()
            ->andReturnFalse();

        $this->expectExceptionMessage(Errors::INSUFFICIENT_ACTION_POINTS);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_recipient_is_not_visible(): void
    {
        $this->allowAllChecksButNot('recipient visible');

        $this->visibilityServiceMock->expects('canSeeSubmarine')
            ->with($this->donorMock, $this->recipientMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::TARGET_NOT_VISIBLE);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_recipient_is_not_within_range(): void
    {
        $this->allowAllChecksButNot('recipient within range');

        $this->shareSonarServiceMock->expects('areSubmarinesWithinRange')
            ->with($this->dataMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::TARGET_TOO_FAR_AWAY);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_sonar_was_already_shared_to_recipient(): void
    {
        $this->allowAllChecksButNot('sonar already shared');

        $this->donorMock->allows('hasSonarSharedTo')
            ->with($this->recipientMock)
            ->once()
            ->andReturnTrue();

        static::expectExceptionMessage(Errors::SONAR_ALREADY_SHARED);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_no_exception_if_the_action_is_valid(): void
    {
        $this->allowAllChecksButNot('nothing');

        static::assertNull($this->validator->validate($this->dataMock));
    }

    protected function allowAllChecksButNot(string $butNot): void
    {
        if ($butNot !== 'recipient is donor') {
            $this->recipientMock->allows('is')
                ->with($this->donorMock)
                ->once()
                ->andReturnFalse();
        }

        if ($butNot !== 'recipient in same game') {
            $this->gameMock->allows('is')
                ->with($this->gameMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'action points required') {
            $this->shareSonarServiceMock->allows('getActionPointsRequired')
                ->with($this->dataMock)
                ->once()
                ->andReturn($this->actionPointsRequiredMock);

            $this->donorActionPointsMock->allows('canAfford')
                ->with($this->actionPointsRequiredMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'recipient visible') {
            $this->visibilityServiceMock->allows('canSeeSubmarine')
                ->with($this->donorMock, $this->recipientMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'recipient within range') {
            $this->shareSonarServiceMock->allows('areSubmarinesWithinRange')
                ->with($this->dataMock)
                ->once()
                ->andReturnTrue();
        }
        if ($butNot !== 'sonar already shared') {
            $this->donorMock->allows('hasSonarSharedTo')
                ->with($this->recipientMock)
                ->once()
                ->andReturnFalse();
        }
    }
}
