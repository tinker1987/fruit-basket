<?php

declare(strict_types=1);

namespace App\BasketContext\Adapters\Doctrine\DBAL\Types;

use App\BasketContext\Domain\VO\Basket\Id;
use App\SharedKernel\Adapters\Doctrine\DBAL\Types\UlidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class BasketIdType extends UlidType
{
    public const NAME = 'basket_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return null === $value ? null : new Id($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return \is_string($value) ? $value : $value?->value;
    }
}