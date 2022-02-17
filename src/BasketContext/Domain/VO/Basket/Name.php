<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\VO\Basket;

use App\SharedKernel\Lib\Assert\Assert;

final class Name implements \Stringable
{
    /**
     * @param string $value
     */
    public function __construct(
        public readonly string $value
    ) {
        Assert::notEmpty($this->value, 'Basket name can\'t be empty');
        Assert::maxLength($this->value, 25, 'Basket name must no longer than 25 characters');
        Assert::regex(
            trim($this->value, '.-'),
            '/[A-Za-z0-9\-.]+/',
            'Only letters, numbers, also - and . in combination with letters and numbers are allowed'
        );
    }

    /**
     * @param Name $other
     * @return bool
     */
    public function equalsTo(Name $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
