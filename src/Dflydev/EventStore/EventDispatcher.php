<?php

namespace Dflydev\EventStore;

interface EventDispatcher
{
    public function dispatch(DispatchableDomainEvent $dispatchableDomainEvent);
}
