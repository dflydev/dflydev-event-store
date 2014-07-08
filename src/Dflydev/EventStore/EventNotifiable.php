<?php

namespace Dflydev\EventStore;

interface EventNotifiable
{
    public function notifyDispatchableEvents();
}
