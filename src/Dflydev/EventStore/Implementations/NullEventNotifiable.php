<?php

namespace Dflydev\EventStore\Implementations;

use Dflydev\EventStore\EventNotifiable;

class NullEventNotifiable implements EventNotifiable
{
    public function notifyDispatchableEvents()
    {
        // noop
    }
}
