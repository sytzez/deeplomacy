<?php

namespace Tests\Game\Actions;

use Game\Actions\AttackSubmarineAction;
use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\AttackSubmarineData;
use Game\Data\GameActionException;
use Game\Enums\Messages;
use Game\Services\AttackSubmarineService;
use Game\Services\WinningService;
use Game\Validators\AttackSubmarineValidator;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class AttackSubmarineActionTest extends TestCase
{
    protected AttackSubmarineValidator|LegacyMockInterface|MockInterface $validatorMock;
    protected LegacyMockInterface|MockInterface|AttackSubmarineService $attackSubmarineServiceMock;
    protected LegacyMockInterface|WinningService|MockInterface $winningServiceMock;

    protected AttackSubmarineAction $action;

    protected GameContract|LegacyMockInterface|MockInterface $gameMock;
    protected LegacyMockInterface|AttackSubmarineData|MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->validatorMock = Mockery::mock(AttackSubmarineValidator::class);
        $this->attackSubmarineServiceMock = Mockery::mock(AttackSubmarineService::class);
        $this->winningServiceMock = Mockery::mock(WinningService::class);

        $this->action = new AttackSubmarineAction(
            $this->validatorMock,
            $this->attackSubmarineServiceMock,
            $this->winningServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->dataMock = Mockery::mock(AttackSubmarineData::class, [
            'getAttacker' => Mockery::mock(SubmarineContract::class, [
                'getGame' => $this->gameMock,
            ]),
            'getTarget'   => Mockery::mock(SubmarineContract::class, [
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
    public function it_returns_a_hit_message_if_the_target_is_hit(): void
    {
        $this->validatorMock->expects('validate')
            ->once()
            ->with($this->dataMock)
            ->andReturnNull();

        $this->attackSubmarineServiceMock->expects('attackSubmarine')
            ->once()
            ->with($this->dataMock)
            ->andReturn(true);

        $this->winningServiceMock->expects('checkVictory')
            ->once()
            ->with($this->gameMock)
            ->andReturnNull();

        $result = $this->action->do($this->dataMock);

        static::assertEquals(Messages::HIT, $result);
    }

    /**
     * @test
     */
    public function it_returns_a_miss_message_if_the_target_is_missed(): void
    {
        $this->validatorMock->expects('validate')
            ->once()
            ->with($this->dataMock)
            ->andReturnNull();

        $this->attackSubmarineServiceMock->expects('attackSubmarine')
            ->once()
            ->with($this->dataMock)
            ->andReturn(false);

        $this->winningServiceMock->expects('checkVictory')
            ->once()
            ->with($this->gameMock)
            ->andReturnNull();

        $result = $this->action->do($this->dataMock);

        static::assertEquals(Messages::MISS, $result);
    }
}
