<?php

namespace Tests\Game\Data;

use Game\Contracts\PlacementStrategyContract;
use Game\Contracts\SubmarineContract;
use Game\Data\JoinGameData;
use Mockery;
use PHPUnit\Framework\TestCase;

class JoinGameDataTest extends TestCase
{
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $submarine;
    protected Mockery\LegacyMockInterface|PlacementStrategyContract|Mockery\MockInterface $placementStrategy;
    protected JoinGameData $joinGameData;

    protected function setUp(): void
    {
        $this->submarine         = Mockery::mock(SubmarineContract::class);
        $this->placementStrategy = Mockery::mock(PlacementStrategyContract::class);
        $this->joinGameData      = new JoinGameData($this->submarine, $this->placementStrategy);
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(JoinGameData::class, $this->joinGameData);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals($this->submarine, $this->joinGameData->getSubmarine());
        static::assertEquals($this->placementStrategy, $this->joinGameData->getPlacementStrategy());
    }
}
