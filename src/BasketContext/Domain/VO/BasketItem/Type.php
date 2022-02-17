<?php

declare(strict_types=1);

namespace App\BasketContext\Domain\VO\BasketItem;

enum Type: string
{
    case ORANGE = 'orange';
    case APPLE = 'apple';
    case WATERMELON = 'watermelon';
}
