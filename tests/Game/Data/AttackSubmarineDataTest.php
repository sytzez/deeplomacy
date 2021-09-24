<?php

namespace Tests\Game\Data;

use Game\Contracts\SubmarineContract;
use Game\Data\AttackSubmarineData;
use Mockery;
use PHPUnit\Framework\TestCase;

class AttackSubmarineDataTest extends TestCase
{
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $attacker;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $target;
    protected AttackSubmarineData $attackSubmarineData;

    protected function setUp(): void
    {
        $this->attacker = Mockery::mock(SubmarineContract::class);
        $this->target = Mockery::mock(SubmarineContract::class);
        $this->attackSubmarineData = new AttackSubmarineData($this->attacker, $this->target);
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(AttackSubmarineData::class, $this->attackSubmarineData);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals($this->attacker, $this->attackSubmarineData->getAttacker());
        static::assertEquals($this->target, $this->attackSubmarineData->getTarget());
    }
}
