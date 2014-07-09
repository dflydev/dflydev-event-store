<?php

namespace Dflydev\EventStore;

trait EventDispatchers
{
    private $eventDispatchers = [];

    protected function eventDispatchers()
    {
        return $this->eventDispatchers;
    }

    protected function registerEventDispatchers(array $eventDispatchers = [])
    {
        $this->eventDispatchers = $eventDispatchers;
    }

    public function registerEventDispatcher(EventDispatcher $eventDispatcher)
    {
        $this->eventDispatchers[] = $eventDispatcher;
    }
}
