<?php

namespace Dflydev\EventStore;

use EventCentric\DomainEvents\DomainEvent;

class DispatchableDomainEvent
{
    private $eventId;
    private $domainEvent;

    public function __construct($eventId, DomainEvent $domainEvent)
    {
        $this->eventId = $eventId;
        $this->domainEvent = $domainEvent;
    }

    public function eventId()
    {
        return $this->eventId;
    }

    public function domainEvent()
    {
        return $this->domainEvent;
    }
}
