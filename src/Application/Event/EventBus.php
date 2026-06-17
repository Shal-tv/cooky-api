<?php

declare(strict_types = 1);

namespace App\Application\Event;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class EventBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->messageBus = $eventBus;
    }

    public function dispatch(EventInterface $event): mixed
    {
        return $this->handle($event);
    }
}
