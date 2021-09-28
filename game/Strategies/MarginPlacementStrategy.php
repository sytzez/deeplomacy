<?php

namespace Game\Strategies;

use Exception;
use Game\Contracts\PlacementStrategyContract;
use Game\Contracts\RngServiceContract;
use Game\Contracts\SubmarineContract;
use Game\Data\Bounds;
use Game\Data\Offset;
use Game\Data\Position;

class MarginPlacementStrategy implements PlacementStrategyContract
{
    public const DEFAULT_MARGIN = 4;

    protected int $margin = self::DEFAULT_MARGIN;

    public function __construct(
        protected RngServiceContract $rngService,
    ) {
    }

    public function setMargin(int $margin): static
    {
        if ($margin < 0) {
            throw new \DomainException();
        }

        $this->margin = $margin;

        return $this;
    }

    public function placeSubmarine(SubmarineContract $submarine): void
    {
        $bounds = $submarine->getGame()->getConfiguration()->getBounds();

        try {
            $boundsWithMargin = new Bounds(
                $bounds->getTopLeft()->translatedBy(new Offset($this->margin, $this->margin)),
                $bounds->getBottomRight()->translatedBy(new Offset(-$this->margin, -$this->margin)),
            );
        } catch (Exception) {
            $boundsWithMargin = $bounds;
        }

        $topLeft = $boundsWithMargin->getTopLeft();
        $bottomRight = $boundsWithMargin->getBottomRight();

        $submarine->setPosition(new Position(
            $this->rngService->getInt($topLeft->getX(), $bottomRight->getX()),
            $this->rngService->getInt($topLeft->getY(), $bottomRight->getY()),
        ));
    }
}
