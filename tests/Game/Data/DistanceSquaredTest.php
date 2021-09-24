<?php

namespace Tests\Game\Data;

use DomainException;
use Game\Data\DistanceSquared;
use PHPUnit\Framework\TestCase;

class DistanceSquaredTest extends TestCase
{
    protected DistanceSquared $d2;
    protected DistanceSquared $d4;

    protected function setUp(): void
    {
        $this->d2 = new DistanceSquared(2);
        $this->d4 = new DistanceSquared(4);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertInstanceOf(DistanceSquared::class, $this->d2);
        static::assertInstanceOf(DistanceSquared::class, $this->d4);

        static::assertEquals(2, $this->d2->getSquared());
        static::assertEquals(4, $this->d4->getSquared());

        static::assertEqualsWithDelta(M_SQRT2, $this->d2->getRoot(), .1);
        static::assertEqualsWithDelta(2, $this->d4->getRoot(), .1);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_on_a_negative_distance(): void
    {
        static::expectException(DomainException::class);

        new DistanceSquared(-1);
    }

    /**
     * @test
     */
    public function it_can_be_compared(): void
    {
        static::assertFalse($this->d2->equals($this->d4));
        static::assertTrue($this->d2->equals(new DistanceSquared(2)));
        static::assertTrue($this->d4->equals(new DistanceSquared(4)));
    }

    /**
     * @test
     */
    public function it_can_check_if_something_fits_inside(): void
    {
        static::assertTrue($this->d2->fitsInside($this->d4));
        static::assertFalse($this->d4->fitsInside($this->d2));
    }
}
