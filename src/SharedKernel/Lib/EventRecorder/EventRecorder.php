<?php

declare(strict_types=1);

namespace App\SharedKernel\Lib\EventRecorder;

interface EventRecorder
{
    public function releaseEvents(): array;
}
