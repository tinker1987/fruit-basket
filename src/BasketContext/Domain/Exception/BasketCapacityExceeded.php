<?php

namespace App\BasketContext\Domain\Exception;

use App\SharedKernel\Domain\Exception\DomainException;

class BasketCapacityExceeded extends DomainException
{
    public function __construct(
        string $message = "Basket capacity exceeded",
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

}