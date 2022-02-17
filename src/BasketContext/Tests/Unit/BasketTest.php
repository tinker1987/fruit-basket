<?php

namespace App\BasketContext\Tests\Unit;

use App\BasketContext\Domain\Entity\Basket;
use App\BasketContext\Domain\Exception\BasketCapacityExceeded;
use App\BasketContext\Domain\VO\Basket\Capacity;
use App\BasketContext\Domain\VO\Basket\Id;
use App\BasketContext\Domain\VO\Basket\Name;
use App\BasketContext\Domain\VO\BasketItem\Type;
use App\BasketContext\Domain\VO\BasketItem\Weight;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class BasketTest extends TestCase
{
    private function getBasket(?string $name = null, ?int $capacity = null): Basket
    {
        $faker = Factory::create();

        return new Basket(
            Id::create(),
            new Name($name ?? $faker->name()),
            new Capacity($capacity ?? $faker->numberBetween(1_000, 10_000))
        );
    }

    public function test_it_can_be_created(): void
    {
        $basket = $this->getBasket();
        self::assertInstanceOf(Basket::class, $basket);
        self::assertNotEmpty($basket->identity());
        self::assertNotEmpty($basket->name());
        self::assertNotEmpty($basket->capacity());
    }

    public function test_it_can_be_renamed()
    {
        $basket = $this->getBasket(name: 'basket');
        $basket->rename(new Name('bazzzket'));
        self::assertTrue($basket->name()->equalsTo(new Name('bazzzket')));
    }

    public function test_it_can_manage_items(): void
    {
        $basket = $this->getBasket(capacity: 1_000);
        $basket->addItem(Type::APPLE, new Weight(170));
        self::assertCount(1, $basket->items());

        $basket->addItem(Type::ORANGE, new Weight(250));
        $basket->addItem(Type::APPLE, new Weight(200));
        self::assertCount(3, $basket->items());

        $basket->empty();
        self::assertCount(0, $basket->items());

        $this->expectException(BasketCapacityExceeded::class);
        $basket->addItem(Type::WATERMELON, new Weight(1_100));
    }
}
