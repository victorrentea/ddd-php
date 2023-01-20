<?php

namespace victor\training\ddd\agile\events;

readonly class AllItemsDoneBeforeSprintEndEvent implements DomainEvent
{
    public function __construct(public int $sprintId)
    {
    }
}