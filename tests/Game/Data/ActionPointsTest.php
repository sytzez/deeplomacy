<?php

namespace Tests\Game\Data;

use DomainException;
use Game\Data\ActionPoints;
use PHPUnit\Framework\TestCase;

class ActionPointsTest extends TestCase
{
    protected ActionPoints $ap0;
    protected ActionPoints $ap1;
    protected ActionPoints $ap100;

    protected function setUp(): void
    {
        $this->ap0 = new ActionPoints(0);
        $this->ap1 = new ActionPoints(1);
        $this->ap100 = new ActionPoints(100);
    }

    /**
     * @test
     */
    public function it_can_be_constructed(): void
    {
        static::assertInstanceOf(ActionPoints::class, $this->ap0);
        static::assertInstanceOf(ActionPoints::class, $this->ap1);
        static::assertInstanceOf(ActionPoints::class, $this->ap100);
    }

    /**
     * @test
     */
    public function it_throws_an_error_on_negative_numbers(): void
    {
        static::expectException(DomainException::class);

        new ActionPoints(-1);
    }

    /**
     * @test
     */
    public function it_can_be_compared(): void
    {
        $otherAp0 = new ActionPoints(0);

        static::assertTrue($this->ap0->equals($otherAp0));
        static::assertFalse($this->ap0->equals($this->ap1));
    }

    /**
     * @test
     */
    public function it_can_be_increased(): void
    {
        $expected = new ActionPoints(101);

        static::assertTrue(
            $this->ap1->increasedBy($this->ap100)
                ->equals($expected)
        );
    }

    /**
     * @test
     */
    public function it_can_be_decreased(): void
    {
        $expected = new ActionPoints(99);

        static::assertTrue(
            $this->ap100->decreasedBy($this->ap1)
                ->equals($expected)
        );
    }

    /**
     * @test
     */
    public function it_can_check_if_it_can_afford_something(): void
    {
        static::assertTrue($this->ap100->canAfford($this->ap1));
        static::assertTrue($this->ap1->canAfford($this->ap0));
        static::assertFalse($this->ap1->canAfford($this->ap100));
        static::assertFalse($this->ap0->canAfford($this->ap1));
    }
}
