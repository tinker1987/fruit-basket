<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Entity;

use App\BasketContext\Domain\VO\BasketItem\Id;
use App\BasketContext\Domain\VO\BasketItem\Type;
use App\BasketContext\Domain\VO\BasketItem\Weight;

class BasketItem implements \JsonSerializable
{
    /**
     * @var Id
     */
    public readonly Id $identity;

    /**
     * @param Basket $basket
     * @param Type $type
     * @param Weight $weight
     */
    private function __construct(
        public readonly Basket $basket,
        public readonly Type $type,
        public readonly Weight $weight,
    ) {
        $this->identity = Id::create();
    }

    public static function orange(Basket $basket, Weight $weight): self
    {
        return new self($basket, Type::ORANGE, $weight);
    }

    public static function apple(Basket $basket, Weight $weight): self
    {
        return new self($basket, Type::APPLE, $weight);
    }

    public static function watermelon(Basket $basket, Weight $weight): self
    {
        return new self($basket, Type::WATERMELON, $weight);
    }

    public function jsonSerialize(): array
    {
        return (array)$this;
    }
}
