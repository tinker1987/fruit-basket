<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Command;

final class CreateBasket
{
    /**
     * @param string $id
     * @param string $name
     * @param string $description
     * @param int $capacity
     */
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly int $capacity,
    ) {
    }
}
