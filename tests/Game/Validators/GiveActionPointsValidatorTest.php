<?php

namespace Tests\Game\Validators;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\ActionPoints;
use Game\Data\GiveActionPointsData;
use Game\Enums\Errors;
use Game\Services\GiveActionPointsService;
use Game\Services\VisibilityService;
use Game\Validators\GiveActionPointsValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class GiveActionPointsValidatorTest extends TestCase
{
    protected Mockery\LegacyMockInterface|GiveActionPointsService|Mockery\MockInterface $giveActionPointsServiceMock;
    protected Mockery\LegacyMockInterface|VisibilityService|Mockery\MockInterface $visibilityServiceMock;

    protected GiveActionPointsValidator $validator;

    protected GameContract|Mockery\LegacyMockInterface|Mockery\MockInterface $gameMock;

    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $amountMock;
    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $donorActionPointsMock;

    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $donorMock;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $recipientMock;

    protected GiveActionPointsData|Mockery\LegacyMockInterface|Mockery\MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->giveActionPointsServiceMock = Mockery::mock(GiveActionPointsService::class);
        $this->visibilityServiceMock = Mockery::mock(VisibilityService::class);

        $this->validator = new GiveActionPointsValidator(
            $this->giveActionPointsServiceMock,
            $this->visibilityServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->amountMock = Mockery::mock(ActionPoints::class);
        $this->donorActionPointsMock = Mockery::mock(ActionPoints::class);

        $this->donorMock = Mockery::mock(SubmarineContract::class, [
            'getGame'         => $this->gameMock,
            'getActionPoints' => $this->donorActionPointsMock,
        ]);

        $this->recipientMock = Mockery::mock(SubmarineContract::class, [
            'getGame' => $this->gameMock,
        ]);

        $this->dataMock = Mockery::mock(GiveActionPointsData::class, [
            'getDonor'        => $this->donorMock,
            'getRecipient'    => $this->recipientMock,
            'getActionPoints' => $this->amountMock,
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

        $this->giveActionPointsServiceMock->expects('areSubmarinesWithinRange')
            ->with($this->dataMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::TARGET_TOO_FAR_AWAY);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_amount_is_zero(): void
    {
        $this->allowAllChecksButNot('action points too low');

        $this->amountMock->expects('getAmount')
            ->withNoArgs()
            ->once()
            ->andReturn(0);

        $this->expectExceptionMessage(Errors::AMOUNT_TOO_LOW);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_donor_cannot_afford_the_amount(): void
    {
        $this->allowAllChecksButNot('action points required');

        $this->donorActionPointsMock->expects('canAfford')
            ->with($this->amountMock)
            ->once()
            ->andReturnFalse();

        $this->expectExceptionMessage(Errors::INSUFFICIENT_ACTION_POINTS);

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

        if ($butNot !== 'recipient visible') {
            $this->visibilityServiceMock->allows('canSeeSubmarine')
                ->with($this->donorMock, $this->recipientMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'recipient within range') {
            $this->giveActionPointsServiceMock->allows('areSubmarinesWithinRange')
                ->with($this->dataMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'action points too low') {
            $this->amountMock->allows('getAmount')
                ->withNoArgs()
                ->once()
                ->andReturn(1);
        }

        if ($butNot !== 'action points required') {
            $this->donorActionPointsMock->allows('canAfford')
                ->with($this->amountMock)
                ->once()
                ->andReturnTrue();
        }
    }
}
