<?php

namespace Tests\Game\Data;

use Game\Contracts\SubmarineContract;
use Game\Data\ActionPoints;
use Game\Data\GiveActionPointsData;
use Mockery;
use PHPUnit\Framework\TestCase;

class GiveActionPointsDataTest extends TestCase
{
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $donor;
    protected Mockery\LegacyMockInterface|SubmarineContract|Mockery\MockInterface $recipient;
    protected Mockery\LegacyMockInterface|ActionPoints|Mockery\MockInterface $actionPoints;
    protected GiveActionPointsData $giveActionPointsData;

    protected function setUp(): void
    {
        $this->donor = Mockery::mock(SubmarineContract::class);
        $this->recipient = Mockery::mock(SubmarineContract::class);
        $this->actionPoints = Mockery::mock(ActionPoints::class);

        $this->giveActionPointsData = new GiveActionPointsData(
            $this->donor,
            $this->recipient,
            $this->actionPoints,
        );
    }

    /**
     * @test
     */
    public function it_can_be_created(): void
    {
        static::assertInstanceOf(GiveActionPointsData::class, $this->giveActionPointsData);
    }

    /**
     * @test
     */
    public function it_returns_the_right_values(): void
    {
        static::assertEquals($this->donor, $this->giveActionPointsData->getDonor());
        static::assertEquals($this->recipient, $this->giveActionPointsData->getRecipient());
        static::assertEquals($this->actionPoints, $this->giveActionPointsData->getActionPoints());
    }

}
