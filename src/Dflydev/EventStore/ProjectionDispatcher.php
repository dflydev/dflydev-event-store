<?php

namespace Dflydev\EventStore;

class ProjectionDispatcher implements EventDispatcher
{
    private $projections;

    public function __construct(array $projections = [])
    {
        $this->projections = $projections;
    }

    public function dispatch(DispatchableDomainEvent $dispatchableDomainEvent)
    {
        foreach ($this->projections as $projection) {
            $projection->dispatch($dispatchableDomainEvent);
        }
    }

    public function registerProjection(Projection $projection)
    {
        $this->projections[] = $projection;
    }
}
