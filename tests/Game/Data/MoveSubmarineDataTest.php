<?php

namespace Tests\Game\Data;

use Game\Contracts\SubmarineContract;
use Game\Data\MoveSubmarineData;
use Game\Data\Offset;
use Mockery;
use PHPUnit\Framework\TestCase;

class MoveSubmarineDataTest extends TestCase
{
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $submarine;
    protected Mockery\LegacyMockInterface|Offset|Mockery\MockInterface $offset;
    protected MoveSubmarineData $moveSubmarineData;

    protected function setUp(): void
    {
        $this->submarine           = Mockery::mock(SubmarineContract::class);
        $this->offset              = Mockery::mock(Offset::class);
        $this->moveSubmarineData = new MoveSubmarineData($this->submarine, $this->offset);
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(MoveSubmarineData::class, $this->moveSubmarineData);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals($this->submarine, $this->moveSubmarineData->getSubmarine());
        static::assertEquals($this->offset, $this->moveSubmarineData->getOffset());
    }
}
