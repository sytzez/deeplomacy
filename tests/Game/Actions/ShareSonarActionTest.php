<?php

namespace Tests\Game\Actions;

use Game\Actions\ShareSonarAction;
use Game\Contracts\GameContract;
use Game\Contracts\SubmarineContract;
use Game\Data\GameActionException;
use Game\Data\ShareSonarData;
use Game\Services\ShareSonarService;
use Game\Services\WinningService;
use Game\Validators\ShareSonarValidator;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ShareSonarActionTest extends TestCase
{
    protected ShareSonarValidator|LegacyMockInterface|MockInterface $validatorMock;
    protected LegacyMockInterface|MockInterface|ShareSonarService $shareSonarServiceMock;
    protected LegacyMockInterface|WinningService|MockInterface $winningServiceMock;

    protected ShareSonarAction $action;

    protected GameContract|LegacyMockInterface|MockInterface $gameMock;
    protected LegacyMockInterface|ShareSonarData|MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->validatorMock         = Mockery::mock(ShareSonarValidator::class);
        $this->shareSonarServiceMock = Mockery::mock(ShareSonarService::class);
        $this->winningServiceMock    = Mockery::mock(WinningService::class);

        $this->action = new ShareSonarAction(
            $this->validatorMock,
            $this->shareSonarServiceMock,
            $this->winningServiceMock,
        );

        $this->gameMock = Mockery::mock(GameContract::class);

        $this->dataMock = Mockery::mock(ShareSonarData::class, [
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

        $this->shareSonarServiceMock->expects('ShareSonar')
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
