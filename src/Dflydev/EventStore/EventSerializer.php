<?php

namespace Dflydev\EventStore;

use EventCentric\DomainEvents\DomainEvent;

interface EventSerializer
{
    public function serialize(DomainEvent $domainEvent);
    public function deserialize($data, $className);
}
