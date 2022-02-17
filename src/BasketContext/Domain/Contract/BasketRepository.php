<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Contract;

use App\BasketContext\Domain\Entity\Basket;
use App\BasketContext\Domain\Exception\BasketNotFound;
use App\BasketContext\Domain\VO\Basket\Id;
use App\BasketContext\Domain\VO\Basket\Name;

interface BasketRepository
{
    /**
     * @param Id $id
     * @return Basket|null
     */
    public function findById(Id $id): ?Basket;

    /**
     * @param Name $name
     * @return Basket|null
     */
    public function findByName(Name $name): ?Basket;

    /**
     * @param Id $id
     * @return Basket
     * @throws BasketNotFound
     */
    public function getById(Id $id): Basket;

    /**
     * @param Basket $basket
     * @return void
     */
    public function save(Basket $basket): void;

    /**
     * @param Basket $basket
     * @return void
     */
    public function delete(Basket $basket): void;
}
