<?php

namespace Game\Data;

use DomainException;

class ActionPoints
{
    final public function __construct(
        protected int $amount,
    ) {
        if ($this->amount < 0) {
            throw new DomainException();
        }
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function increasedBy(self $points): static
    {
        return new static(
            $this->getAmount() + $points->getAmount()
        );
    }

    public function decreasedBy(self $points): static
    {
        return new static(
            $this->getAmount() - $points->getAmount()
        );
    }

    public function canAfford(self $points): bool
    {
        return $this->getAmount() >= $points->getAmount();
    }

    public function equals(self $actionPoints): bool
    {
        return $this->getAmount() === $actionPoints->getAmount();
    }
}
