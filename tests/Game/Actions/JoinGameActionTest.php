<?php

namespace Tests\Game\Actions;

use Game\Actions\JoinGameAction;
use Game\Contracts\ConfigurationContract;
use Game\Contracts\GameContract;
use Game\Contracts\PlacementStrategyContract;
use Game\Contracts\SubmarineContract;
use Game\Contracts\SubmarineRepositoryContract;
use Game\Data\ActionPoints;
use Game\Data\JoinGameData;
use Game\Data\Position;
use Game\Services\WinningService;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class JoinGameActionTest extends TestCase
{
    protected LegacyMockInterface|SubmarineRepositoryContract|MockInterface $submarineRepositoryMock;
    protected LegacyMockInterface|WinningService|MockInterface $winningServiceMock;

    protected JoinGameAction $action;

    protected LegacyMockInterface|PlacementStrategyContract|MockInterface $placementStrategyMock;

    protected LegacyMockInterface|ActionPoints|MockInterface $actionPointsMock;
    protected GameContract|LegacyMockInterface|MockInterface $gameMock;
    protected LegacyMockInterface|SubmarineContract|MockInterface $submarineMock;
    protected LegacyMockInterface|JoinGameData|MockInterface $dataMock;

    protected function setUp(): void
    {
        $this->submarineRepositoryMock = Mockery::mock(SubmarineRepositoryContract::class);
        $this->winningServiceMock = Mockery::mock(WinningService::class);

        $this->action = new JoinGameAction(
            $this->submarineRepositoryMock,
            $this->winningServiceMock,
        );

        $this->placementStrategyMock = Mockery::mock(PlacementStrategyContract::class);

        $this->actionPointsMock = Mockery::mock(ActionPoints::class);

        $this->gameMock = Mockery::mock(GameContract::class, [
            'getConfiguration' => Mockery::mock(ConfigurationContract::class, [
                'getAmountOfActionPointsDistributed' => $this->actionPointsMock,
            ])
        ]);

        $this->submarineMock = Mockery::mock(SubmarineContract::class, [
            'getGame'     => $this->gameMock,
            'getPosition' => Mockery::mock(Position::class),
        ]);

        $this->dataMock = Mockery::mock(JoinGameData::class, [
            'getSubmarine'         => $this->submarineMock,
            'getPlacementStrategy' => $this->placementStrategyMock,
        ]);
    }

    /**
     * @test
     */
    public function it_places_the_submarine_and_grants_action_points(): void
    {
        $this->placementStrategyMock->expects('placeSubmarine')
            ->once()
            ->with($this->submarineMock)
            ->andReturnNull();

        $this->submarineRepositoryMock->expects('getAtPosition')
            ->once()
            ->with($this->gameMock, $this->submarineMock->getPosition())
            ->andReturnNull();

        $this->submarineRepositoryMock->expects('update')
            ->once()
            ->with($this->submarineMock)
            ->andReturnSelf();

        $this->submarineMock->expects('setActionPoints')
            ->once()
            ->with($this->actionPointsMock)
            ->andReturnSelf();

        $this->winningServiceMock->expects('checkVictory')
            ->once()
            ->with($this->gameMock)
            ->andReturnNull();

        $this->action->do($this->dataMock);

        static::assertNull(Mockery::close());
    }

    /**
     * @test
     */
    public function it_places_the_submarine_again_if_there_is_already_a_submarine_at_the_position(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $this->placementStrategyMock->expects('placeSubmarine')
                ->once()
                ->with($this->submarineMock)
                ->andReturnNull();

            $this->submarineRepositoryMock->expects('getAtPosition')
                ->once()
                ->with($this->gameMock, $this->submarineMock->getPosition())
                ->andReturn(Mockery::mock(SubmarineContract::class));
        }

        $this->placementStrategyMock->expects('placeSubmarine')
            ->once()
            ->with($this->submarineMock)
            ->andReturnNull();

        $this->submarineRepositoryMock->expects('getAtPosition')
            ->once()
            ->with($this->gameMock, $this->submarineMock->getPosition())
            ->andReturnNull();

        $this->submarineRepositoryMock->expects('update')
            ->once()
            ->with($this->submarineMock)
            ->andReturnSelf();

        $this->submarineMock->expects('setActionPoints')
            ->once()
            ->with($this->actionPointsMock)
            ->andReturnSelf();

        $this->winningServiceMock->expects('checkVictory')
            ->once()
            ->with($this->gameMock)
            ->andReturnNull();

        $this->action->do($this->dataMock);

        static::assertNull(Mockery::close());
    }
}
