<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\VO\BasketItem;

class Weight
{
    public function __construct(
        public readonly int $value
    ) {
    }

    /**
     * @param Weight $other
     * @return bool
     */
    public function equalsTo(Weight $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->value;
    }

}
