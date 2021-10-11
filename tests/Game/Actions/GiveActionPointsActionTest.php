<?php

namespace Tests\Game\Actions;

use Game\Actions\GiveActionPointsAction;
use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\GameActionException;
use Game\Data\GiveActionPointsData;
use Game\Services\GiveActionPointsService;
use Game\Services\WinningService;
use Game\Validators\GiveActionPointsValidator;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class GiveActionPointsActionTest extends TestCase
{
    protected GiveActionPointsValidator|LegacyMockInterface|MockInterface $validatorMock;
    protected LegacyMockInterface|MockInterface|GiveActionPointsService $giveActionPointsServiceMock;
    protected LegacyMockInterface|WinningService|MockInterface $winningServiceMock;

    protected GiveActionPointsAction $action;

    protected GameContract|LegacyMockInterface|MockInterface $gameMock;
    protected LegacyMockInterface|GiveActionPointsData|MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->validatorMock = Mockery::mock(GiveActionPointsValidator::class);
        $this->giveActionPointsServiceMock = Mockery::mock(GiveActionPointsService::class);
        $this->winningServiceMock = Mockery::mock(WinningService::class);

        $this->action = new GiveActionPointsAction(
            $this->validatorMock,
            $this->giveActionPointsServiceMock,
            $this->winningServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->dataMock = Mockery::mock(GiveActionPointsData::class, [
            'getDonor'     => Mockery::mock(SubmarineContract::class, [
                'getGame' => $this->gameMock,
            ]),
            'getRecipient' => Mockery::mock(SubmarineContract::class, [
                'getGame' => $this->gameMock,
            ]),
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_error_if_validation_fails(): void
    {
        $this->validatorMock->expects('validate')
            ->once()
            ->with($this->dataMock)
            ->andThrow(new GameActionException());

        static::expectException(GameActionException::class);

        $this->action->do($this->dataMock);
    }

    /**
     * @test
     */
    public function it_completes_an_action(): void
    {
        $this->validatorMock->expects('validate')
            ->once()
            ->with($this->dataMock)
            ->andReturnNull();

        $this->giveActionPointsServiceMock->expects('giveActionPoints')
            ->once()
            ->with($this->dataMock)
            ->andReturn(true);

        $this->winningServiceMock->expects('checkVictory')
            ->once()
            ->with($this->gameMock)
            ->andReturnNull();

        $this->action->do($this->dataMock);

        static::assertNull(Mockery::close());
    }
}
