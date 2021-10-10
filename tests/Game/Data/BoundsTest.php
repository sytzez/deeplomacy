<?php

namespace Tests\Game\Data;

use DomainException;
use Game\Data\Bounds;
use Game\Data\Position;
use PHPUnit\Framework\TestCase;

class BoundsTest extends TestCase
{
    protected Position $topLeft;
    protected Position $bottomRight;
    protected Bounds $bounds;

    protected function setUp(): void
    {
        $this->topLeft = new Position(-10, -5);
        $this->bottomRight = new Position(8, 7);

        $this->bounds = new Bounds(
            $this->topLeft,
            $this->bottomRight,
        );
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(Bounds::class, $this->bounds);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_the_directions_are_flipped(): void
    {
        static::expectException(DomainException::class);

        new Bounds($this->bottomRight, $this->topLeft);
    }

    /**
     * @test
     */
    public function it_can_check_positions_that_are_contained_within_it(): void
    {
        $insideCoordinates = [
            [-10, -5],
            [8, -5],
            [8, 7],
            [-10, 7],
            [0, 0],
            [3, 2],
            [-9, -4],
        ];

        foreach ($insideCoordinates as $coordinates) {

            $position = new Position($coordinates[0], $coordinates[1]);

            static::assertTrue($this->bounds->containsPosition($position));
        }
    }

    /**
     * @test
     */
    public function it_can_check_positions_that_are_outside_itself(): void
    {
        $outsideCoordinates = [
            [-11, -5],
            [9, -6],
            [8, -6],
            [-10, 8],
            [100, 0],
            [-100, 2],
            [-9, -100],
            [4, 100],
        ];

        foreach ($outsideCoordinates as $coordinates) {

            $position = new Position($coordinates[0], $coordinates[1]);

            static::assertFalse($this->bounds->containsPosition($position), serialize($position));
        }
    }
}
