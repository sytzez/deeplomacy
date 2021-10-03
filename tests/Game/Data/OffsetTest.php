<?php

namespace Tests\Game\Data;

use Game\Data\DistanceSquared;
use Game\Data\Offset;
use PHPUnit\Framework\TestCase;

class OffsetTest extends TestCase
{
    protected Offset $zeroOffset;
    protected Offset $offset1;
    protected Offset $offset2;
    protected Offset $offset3;

    protected function setUp(): void
    {
        $this->zeroOffset = new Offset(0, 0);
        $this->offset1 = new Offset(2, 3);
        $this->offset2 = new Offset(-2, -3);
        $this->offset3 = new Offset(4, 5);
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(Offset::class, $this->zeroOffset);
        static::assertInstanceOf(Offset::class, $this->offset1);
        static::assertInstanceOf(Offset::class, $this->offset2);
        static::assertInstanceOf(Offset::class, $this->offset3);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals(0, $this->zeroOffset->getDx());
        static::assertEquals(0, $this->zeroOffset->getDy());
        static::assertEquals(2, $this->offset1->getDx());
        static::assertEquals(3, $this->offset1->getDy());
        static::assertEquals(-2, $this->offset2->getDx());
        static::assertEquals(-3, $this->offset2->getDy());
        static::assertEquals(4, $this->offset3->getDx());
        static::assertEquals(5, $this->offset3->getDy());
    }

    /**
     * @test
     */
    public function it_returns_the_right_distance_squared(): void
    {
        static::assertTrue(
            $this->zeroOffset->getDistanceSquared()
                ->equals(new DistanceSquared(0))
        );

        static::assertTrue(
            $this->offset1->getDistanceSquared()
                ->equals(new DistanceSquared(13))
        );

        static::assertTrue(
            $this->offset2->getDistanceSquared()
                ->equals(new DistanceSquared(13))
        );

        static::assertTrue(
            $this->offset3->getDistanceSquared()
                ->equals(new DistanceSquared(41))
        );
    }

    /**
     * @test
     */
    public function it_can_be_compared(): void
    {
        static::assertFalse($this->zeroOffset->equals($this->offset1));
        static::assertFalse($this->offset1->equals($this->offset2));
        static::assertTrue($this->offset3->equals(new Offset(4, 5)));
    }
}
