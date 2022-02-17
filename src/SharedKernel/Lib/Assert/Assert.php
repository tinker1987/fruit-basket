<?php

declare(strict_types=1);

namespace App\SharedKernel\Lib\Assert;

use App\SharedKernel\Domain\Exception\InvalidArgumentException;

final class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param $message
     * @return void
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidArgumentException($message);
    }

}
