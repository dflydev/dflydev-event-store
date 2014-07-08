<?php

namespace Dflydev\EventStore\Implementations;

use Dflydev\EventStore\EventStream;
use EventCentric\DomainEvents\DomainEvents;

class DefaultEventStream implements EventStream
{
    private $domainEvents;
    private $version;

    public function __construct(DomainEvents $domainEvents, $version)
    {
        $this->domainEvents = $domainEvents;
        $this->version = $version;
    }

    public function domainEvents()
    {
        return $this->domainEvents;
    }

    public function version()
    {
        return $this->version;
    }
}
