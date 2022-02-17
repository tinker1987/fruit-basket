<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Entity;

use App\BasketContext\Domain\Exception\BasketCapacityExceeded;
use App\BasketContext\Domain\Exception\BasketItemNotFound;
use App\BasketContext\Domain\VO\Basket\Capacity;
use App\BasketContext\Domain\VO\Basket\Id;
use App\BasketContext\Domain\VO\Basket\Name;
use App\BasketContext\Domain\VO\BasketItem\Type;
use App\BasketContext\Domain\VO\BasketItem\Weight;
use App\SharedKernel\Lib\EventRecorder\EventRecordable;
use App\SharedKernel\Lib\EventRecorder\EventRecorder;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass="App\BasketContext\Adapters\Repositories\DoctrineBasketRepository::class")
 */
final class Basket implements \JsonSerializable, EventRecorder
{
    use EventRecordable;

    /**
     * @var Collection
     */
    private Collection $items;

    /**
     * @param Id $identity
     * @param Name $name
     * @param Capacity $capacity
     */
    #[Pure] public function __construct(
        /**
         * @ORM\Id()
         * @ORM\Column(type="basket_id")
         */
        private Id $identity,
        /**
         * @ORM\Column(type="basket_name")
         */
        private Name $name,
        /**
         * @ORM\Column(type="basket_capacity")
         */
        private Capacity $capacity
    ) {
        $this->items = new ArrayCollection();
    }

    /**
     * @return Id
     */
    public function identity(): Id
    {
        return $this->identity;
    }

    /**
     * @return Name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * @param Name $newName
     * @return void
     */
    public function rename(Name $newName): void
    {
        if (!$this->name->equalsTo($newName)) {
            $this->name = $newName;
        }
    }

    /**
     * @return Capacity
     */
    public function capacity(): Capacity
    {
        return $this->capacity;
    }

    /**
     * @param Type $type
     * @param Weight $weight
     * @return void
     */
    public function addItem(Type $type, Weight $weight): void
    {
        if ($this->currentWeight() + $weight->value > $this->capacity->value) {
            throw new BasketCapacityExceeded();
        }
        $item = match ($type) {
            Type::APPLE => BasketItem::apple($this, $weight),
            Type::ORANGE => BasketItem::orange($this, $weight),
            Type::WATERMELON => BasketItem::watermelon($this, $weight),
        };

        $this->items->set($item->identity->value, $item);
    }

    /**
     * @return int
     */
    private function currentWeight(): int
    {
        return array_reduce(
            $this->items->map(fn(BasketItem $item): int => $item->weight->value)->getValues(),
            static fn(int $carrier, int $v) => $carrier + $v,
            0
        );
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items->getValues();
    }

    /**
     * @param \App\BasketContext\Domain\VO\BasketItem\Id $id
     * @return void
     */
    public function removeItem(\App\BasketContext\Domain\VO\BasketItem\Id $id): void
    {
        if (!$this->items->containsKey($id->value)) {
            throw new BasketItemNotFound("Item ID=$id->value not found in current basket");
        }

        $this->items->remove($id->value);
    }

    /**
     * @return void
     */
    public function empty(): void
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return array
     */
    #[ArrayShape([
        'identity' => 'string',
        'name' => 'string',
        'capacity' => 'int',
        'items' => 'array'
    ])] public function jsonSerialize(): array
    {
        return [
            'identity' => $this->identity->value,
            'name' => $this->name->value,
            'capacity' => $this->capacity->value,
            'items' => $this->items->map(fn(BasketItem $item) => (array)$item)->toArray()
        ];
    }
}
