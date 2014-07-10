<?php

namespace Dflydev\EventStore;

use Dflydev\EventStore\EventNotifiable;

class EventNotifiableChain implements EventNotifiable
{
    private $eventNotifiables;

    public function __construct(array $eventNotifiables = [])
    {
    	$this->eventNotifiables = $eventNotifiables;
    }

    public function notifyDispatchableEvents()
    {
        foreach ($this->eventNotifiables as $eventNotifiable) {
            $eventNotifiable->notifyDispatchableEvents();
        }
    }

    public function registerEventNotifiable(EventNotifiable $eventNotifiable)
    {
        $this->eventNotifiables[] = $eventNotifiable;
    }
}
