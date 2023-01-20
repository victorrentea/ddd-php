<?php

namespace victor\training\ddd\agile;

use Psr\EventDispatcher\EventDispatcherInterface;
use victor\training\ddd\agile\events\DomainEvent;

class BaseAggregate
{
    /** @var DomainEvent[] */
    protected array $domainEvents = [];

    #[PostFlush] // fired by ORM
    public function afterInsert(EventDispatcherInterface $eventDispatcher)
    {
        foreach ($this->domainEvents as $domainEvent) {
            $eventDispatcher->dispatch($domainEvent, $domainEvent::class);
        }
    }
}