<?php

namespace Dflydev\EventStore;

use EventCentric\DomainEvents\DomainEvents;

interface EventStore
{
    public function appendWith(EventStreamId $eventStreamId, DomainEvents $domainEvents);
    public function eventStreamSince(EventStreamId $eventStreamId);
    public function fullEventStreamFor(EventStreamId $eventStreamId);
}
