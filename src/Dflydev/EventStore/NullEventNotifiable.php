<?php

namespace Dflydev\EventStore;

use Dflydev\EventStore\EventNotifiable;

class NullEventNotifiable implements EventNotifiable
{
    public function notifyDispatchableEvents()
    {
        // noop
    }
}
