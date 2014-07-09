<?php

namespace Dflydev\EventStore\Implementations;

use Dflydev\EventStore\EventSerializer;
use EventCentric\DomainEvents\DomainEvent;

abstract class JsonEventSerializer implements EventSerializer
{
    public function serialize(DomainEvent $domainEvent)
    {
        return json_encode($domainEvent);
    }
}
