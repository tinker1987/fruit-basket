<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\Exception;

use App\SharedKernel\Domain\Exception\EntityNotFoundException;

class BasketItemNotFound extends EntityNotFoundException
{

}