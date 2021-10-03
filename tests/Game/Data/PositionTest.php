<?php

namespace Tests\Game\Data;

use Game\Data\Offset;
use Game\Data\Position;
use PHPUnit\Framework\TestCase;

class PositionTest extends TestCase
{
    protected Position $zeroPosition;
    protected Position $position1;
    protected Position $position2;

    protected function setUp(): void
    {
        $this->zeroPosition = new Position(0, 0);
        $this->position1 = new Position(2, 3);
        $this->position2 = new Position(-2, -3);
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(Position::class, $this->zeroPosition);
        static::assertInstanceOf(Position::class, $this->position1);
        static::assertInstanceOf(Position::class, $this->position2);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals(0, $this->zeroPosition->getX());
        static::assertEquals(0, $this->zeroPosition->getY());
        static::assertEquals(2, $this->position1->getX());
        static::assertEquals(3, $this->position1->getY());
        static::assertEquals(-2, $this->position2->getX());
        static::assertEquals(-3, $this->position2->getY());
    }

    /**
     * @test
     */
    public function it_can_be_compared(): void
    {
        static::assertFalse($this->zeroPosition->equals($this->position1));
        static::assertFalse($this->position1->equals($this->position2));
        static::assertTrue($this->position2->equals(new Position(-2, -3)));
    }

    /**
     * @test
     */
    public function it_can_provide_offsets(): void
    {
        static::assertTrue(
            $this->zeroPosition->getOffsetTo($this->position1)
                ->equals(new Offset(2, 3))
        );

        static::assertTrue(
            $this->position1->getOffsetTo($this->zeroPosition)
                ->equals(new Offset(-2, -3))
        );

        static::assertTrue(
            $this->position2->getOffsetTo($this->position1)
                ->equals(new Offset(4, 6))
        );
    }

    /**
     * @test
     */
    public function it_can_be_translated(): void
    {
        static::assertTrue(
            $this->zeroPosition->translatedBy(new Offset(4, 5))
                ->equals(new Position(4, 5))
        );

        static::assertTrue(
            $this->position1->translatedBy(new Offset(-10, -10))
                ->equals(new Position(-8, -7))
        );
    }

    /**
     * @test
     */
    public function it_can_check_if_it_is_top_left_of_another_position(): void
    {
        static::assertTrue($this->zeroPosition->isTopLeftOf(new Position(0, 0)));
        static::assertTrue($this->zeroPosition->isTopLeftOf($this->position1));

        static::assertFalse($this->zeroPosition->isTopLeftOf($this->position2));

        static::assertFalse($this->position1->isTopLeftOf($this->position2));

        static::assertTrue($this->position2->isTopLeftOf($this->position1));

        static::assertFalse($this->position1->isTopLeftOf(new Position(3, 2)));

        static::assertFalse($this->position1->isTopLeftOf(new Position(1, 4)));
    }
}
