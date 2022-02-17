<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\VO;

use App\SharedKernel\Lib\Assert\Assert;
use Symfony\Component\Uid\Ulid;

abstract class AbstractIdentity implements \Stringable
{
    /**
     * @param string $value
     */
    public function __construct(
        public readonly string $value
    ) {
        Assert::true(Ulid::isValid($value), "Specified value '$value' is invalid");
    }

    /**
     * @return static
     */
    public static function create(): static
    {
        return new static((new Ulid())->toBase32());
    }

    /**
     * @param AbstractIdentity $other
     * @return bool
     */
    public function equalsTo(AbstractIdentity $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
