<?php

namespace Tests\Game\Data;

use Game\Contracts\SubmarineContract;
use Game\Data\ActionPoints;
use Game\Data\Cell;
use Game\Data\Position;
use Mockery;
use PHPUnit\Framework\TestCase;

class CellTest extends TestCase
{
    /**
     * @return array<array<bool>>
     */
    public function dataProvider(): array {
        return [
            [true, false, true, false, true],
            [false, true, false, true, false],
            [true, true, false, false, true],
            [false, false, true, true, false],
        ];
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function it_can_be_created_without_submarine(
        bool $isVisible,
        bool $canMoveTowards,
    ): void {
        $cell = new Cell(
            Mockery::mock(Position::class),
            $isVisible,
            $canMoveTowards,
            Mockery::mock(ActionPoints::class),
        );

        static::assertInstanceOf(Cell::class, $cell);
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function it_returns_the_right_values(
        bool $isVisible,
        bool $canMoveTowards,
        bool $canAttack,
        bool $canShareSonar,
        bool $canGiveActionPoints,
    ): void {
        $position = Mockery::mock(Position::class);
        $actionPointsToMove = Mockery::mock(ActionPoints::class);
        $submarine = Mockery::mock(SubmarineContract::class);
        $actionPointsToAttack = Mockery::mock(ActionPoints::class);
        $actionPointsToShareSonar = Mockery::mock(ActionPoints::class);

        $cell = new Cell(
            $position,
            $isVisible,
            $canMoveTowards,
            $actionPointsToMove,
            $submarine,
            $canAttack,
            $actionPointsToAttack,
            $canShareSonar,
            $actionPointsToShareSonar,
            $canGiveActionPoints
        );

        static::assertInstanceOf(Cell::class, $cell);

        static::assertEquals($position, $cell->getPosition());
        static::assertEquals($isVisible, $cell->isVisible());
        static::assertEquals($canMoveTowards, $cell->canMoveTowards());
        static::assertEquals($actionPointsToMove, $cell->getActionPointsToMove());
        static::assertEquals($submarine, $cell->getSubmarine());
        static::assertEquals($canAttack, $cell->canAttack());
        static::assertEquals($actionPointsToAttack, $cell->getActionPointsToAttack());
        static::assertEquals($canShareSonar, $cell->canShareSonar());
        static::assertEquals($actionPointsToShareSonar, $cell->getActionPointsToShareSonar());
        static::assertEquals($canGiveActionPoints, $cell->canGiveActionPoints());
    }

    /**
     * @test
     * @dataProvider dataProvider
     */
    public function it_can_be_given_a_submarine(
        bool $isVisible,
        bool $canMoveTowards,
        bool $canAttack,
        bool $canShareSonar,
        bool $canGiveActionPoints,
    ): void {
        $position = Mockery::mock(Position::class);
        $actionPointsToMove = Mockery::mock(ActionPoints::class);
        $submarine = Mockery::mock(SubmarineContract::class);
        $actionPointsToAttack = Mockery::mock(ActionPoints::class);
        $actionPointsToShareSonar = Mockery::mock(ActionPoints::class);

        $cell = (
            new Cell(
                $position,
                $isVisible,
                $canMoveTowards,
                $actionPointsToMove,
            )
        )->withSubmarine(
            $submarine,
            $canAttack,
            $actionPointsToAttack,
            $canShareSonar,
            $actionPointsToShareSonar,
            $canGiveActionPoints,
        );

        static::assertInstanceOf(Cell::class, $cell);

        static::assertEquals($position, $cell->getPosition());
        static::assertEquals($isVisible, $cell->isVisible());
        static::assertEquals($canMoveTowards, $cell->canMoveTowards());
        static::assertEquals($actionPointsToMove, $cell->getActionPointsToMove());
        static::assertEquals($submarine, $cell->getSubmarine());
        static::assertEquals($canAttack, $cell->canAttack());
        static::assertEquals($actionPointsToAttack, $cell->getActionPointsToAttack());
        static::assertEquals($canShareSonar, $cell->canShareSonar());
        static::assertEquals($actionPointsToShareSonar, $cell->getActionPointsToShareSonar());
        static::assertEquals($canGiveActionPoints, $cell->canGiveActionPoints());
    }
}
