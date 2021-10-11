<?php

namespace Tests\Game\Actions;

use Game\Actions\MoveSubmarineAction;
use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\GameActionException;
use Game\Data\MoveSubmarineData;
use Game\Services\MoveSubmarineService;
use Game\Services\WinningService;
use Game\Validators\MoveSubmarineValidator;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class MoveSubmarineActionTest extends TestCase
{
    protected MoveSubmarineValidator|LegacyMockInterface|MockInterface $validatorMock;
    protected LegacyMockInterface|MockInterface|MoveSubmarineService $moveSubmarineServiceMock;
    protected LegacyMockInterface|WinningService|MockInterface $winningServiceMock;

    protected MoveSubmarineAction $action;

    protected GameContract|LegacyMockInterface|MockInterface $gameMock;
    protected LegacyMockInterface|MoveSubmarineData|MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->validatorMock            = Mockery::mock(MoveSubmarineValidator::class);
        $this->moveSubmarineServiceMock = Mockery::mock(MoveSubmarineService::class);
        $this->winningServiceMock       = Mockery::mock(WinningService::class);

        $this->action = new MoveSubmarineAction(
            $this->validatorMock,
            $this->moveSubmarineServiceMock,
            $this->winningServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->dataMock = Mockery::mock(MoveSubmarineData::class, [
            'getSubmarine' => Mockery::mock(SubmarineContract::class, [
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

        $this->moveSubmarineServiceMock->expects('MoveSubmarine')
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
