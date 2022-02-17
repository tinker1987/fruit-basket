<?php

declare(strict_types=1);

namespace App\SharedKernel\Lib\EventRecorder;

trait EventRecordable
{
    /**
     * @var object[]
     */
    protected array $events = [];

    public function releaseEvents(): array
    {
        $events = $this->events;
        $this->eraseEvents();

        return $events;
    }

    protected function eraseEvents(): void
    {
        $this->events = [];
    }

    protected function record(object $event): void
    {
        $this->events[] = $event;
    }
}