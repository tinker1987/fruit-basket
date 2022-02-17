<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Service;

use App\BasketContext\Domain\Contract\BasketRepository;
use App\BasketContext\Domain\Entity\Basket;
use App\BasketContext\Domain\VO\Basket\Capacity;
use App\BasketContext\Domain\VO\Basket\Id;
use App\BasketContext\Domain\VO\Basket\Name;

class CreateBasket
{
    /**
     * @param BasketRepository $repository
     */
    public function __construct(private BasketRepository $repository)
    {
    }

    /**
     * @param Id $id
     * @param Name $name
     * @param Capacity $capacity
     * @return Basket
     */
    public function __invoke(
        Id $id,
        Name $name,
        Capacity $capacity
    ): Basket {
        // TODO: put logic here...
    }
}
