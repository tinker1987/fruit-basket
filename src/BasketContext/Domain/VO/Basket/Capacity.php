<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\VO\Basket;

use App\SharedKernel\Lib\Assert\Assert;

final class Capacity implements \Stringable
{
    /**
     * @param int $value
     */
    public function __construct(
        public readonly int $value
    ) {
        Assert::greaterThanEq($this->value, 1_000, 'Basket capacity must be greater or equals to 1,000 gram');
        Assert::lessThanEq($this->value, 10_000, 'Basket capacity must be less or equals to 10,000 gram');
    }

    /**
     * @param Capacity $other
     * @return bool
     */
    public function equalsTo(Capacity $other): bool
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
