<?php

namespace Tests\Game\Validators;

use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\ActionPoints;
use Game\Data\AttackSubmarineData;
use Game\Enums\Errors;
use Game\Services\AttackSubmarineService;
use Game\Services\VisibilityService;
use Game\Validators\AttackSubmarineValidator;
use Mockery;
use PHPUnit\Framework\TestCase;

class AttackSubmarineValidatorTest extends TestCase
{
    protected Mockery\LegacyMockInterface|Mockery\MockInterface|AttackSubmarineService $attackSubmarineServiceMock;
    protected Mockery\LegacyMockInterface|VisibilityService|Mockery\MockInterface $visibilityServiceMock;

    protected AttackSubmarineValidator $validator;

    protected GameContract|Mockery\LegacyMockInterface|Mockery\MockInterface $gameMock;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $attackerMock;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $targetMock;
    protected Mockery\LegacyMockInterface|AttackSubmarineData|Mockery\MockInterface $dataMock;

    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $attackersActionPointsMock;
    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $actionPointsRequiredMock;

    protected function setUp(): void
    {
        $this->attackSubmarineServiceMock = Mockery::mock(AttackSubmarineService::class);
        $this->visibilityServiceMock = Mockery::mock(VisibilityService::class);

        $this->validator = new AttackSubmarineValidator(
            $this->attackSubmarineServiceMock,
            $this->visibilityServiceMock,
        );

        $this->attackersActionPointsMock = Mockery::mock(ActionPoints::class);
        $this->actionPointsRequiredMock = Mockery::mock(ActionPoints::class);

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->attackerMock = Mockery::mock(SubmarineContract::class, [
            'getGame'         => $this->gameMock,
            'getActionPoints' => $this->attackersActionPointsMock,
        ]);

        $this->targetMock = Mockery::mock(SubmarineContract::class, [
            'getGame' => $this->gameMock,
        ]);

        $this->dataMock = Mockery::mock(AttackSubmarineData::class, [
            'getAttacker' => $this->attackerMock,
            'getTarget'   => $this->targetMock,
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_target_is_the_attacker(): void
    {
        $this->allowAllChecksButNot('attacker is target');

        $this->attackerMock->expects('is')
            ->with($this->targetMock)
            ->once()
            ->andReturnTrue();

        static::expectExceptionMessage(Errors::CANNOT_TARGET_SELF);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_target_is_not_in_the_same_game(): void
    {
        $this->allowAllChecksButNot('target in same game');

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
    public function it_throws_an_exception_if_the_attacker_cannot_afford_the_action(): void
    {
        $this->allowAllChecksButNot('action points required');

        $this->attackSubmarineServiceMock->expects('getActionPointsRequired')
            ->with($this->dataMock)
            ->once()
            ->andReturn($this->actionPointsRequiredMock);

        $this->attackersActionPointsMock->expects('canAfford')
            ->with($this->actionPointsRequiredMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::INSUFFICIENT_ACTION_POINTS);

        $this->validator->validate($this->dataMock);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_attacker_cannot_see_the_target(): void
    {
        $this->allowAllChecksButNot('target visible');

        $this->visibilityServiceMock->expects('canSeeSubmarine')
            ->with($this->attackerMock, $this->targetMock)
            ->once()
            ->andReturnFalse();

        static::expectExceptionMessage(Errors::TARGET_NOT_VISIBLE);

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
        if ($butNot !== 'attacker is target') {
            $this->attackerMock->allows('is')
                ->with($this->targetMock)
                ->once()
                ->andReturnFalse();
        }

        if ($butNot !== 'target in same game') {
            $this->gameMock->allows('is')
                ->with($this->gameMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'action points required') {
            $this->attackSubmarineServiceMock->allows('getActionPointsRequired')
                ->with($this->dataMock)
                ->once()
                ->andReturn($this->actionPointsRequiredMock);

            $this->attackersActionPointsMock->allows('canAfford')
                ->with($this->actionPointsRequiredMock)
                ->once()
                ->andReturnTrue();
        }

        if ($butNot !== 'target visible') {
            $this->visibilityServiceMock->allows('canSeeSubmarine')
                ->with($this->attackerMock, $this->targetMock)
                ->once()
                ->andReturnTrue();
        }
    }
}
