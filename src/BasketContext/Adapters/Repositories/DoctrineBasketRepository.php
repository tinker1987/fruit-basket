<?php

declare(strict_types=1);

namespace App\BasketContext\Adapters\Repositories;

use App\BasketContext\Domain\Contract\BasketRepository;
use App\BasketContext\Domain\Entity\Basket;
use App\BasketContext\Domain\Exception\BasketNotFound;
use App\BasketContext\Domain\VO\Basket\Id;
use App\BasketContext\Domain\VO\Basket\Name;
use Doctrine\ORM\EntityRepository;

class DoctrineBasketRepository extends EntityRepository implements BasketRepository
{
    /**
     * @inheritdoc
     */
    public function findById(Id $id): ?Basket
    {
        return $this->find($id->value);
    }

    /**
     * @inheritdoc
     */
    public function findByName(Name $name): ?Basket
    {
        return $this->findOneBy(['name' => $name]);
    }

    /**
     * @inheritdoc
     */
    public function getById(Id $id): Basket
    {
        $basket = $this->findById($id);
        if (!$basket instanceof Basket) {
            throw new BasketNotFound("Basket ID=$id->value not found");
        }
        return $basket;
    }

    /**
     * @inheritdoc
     */
    public function save(Basket $basket): void
    {
        $em = $this->getEntityManager();

        if (!$em->contains($basket)) {
            $this->getEntityManager()->persist($basket);
        }

        $em->flush();
    }

    /**
     * @inheritdoc
     */
    public function delete(Basket $basket): void
    {
        $em = $this->getEntityManager();
        $em->remove($basket);
        $em->flush();
    }
}
