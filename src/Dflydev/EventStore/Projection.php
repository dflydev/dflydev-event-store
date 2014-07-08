<?php

namespace Dflydev\EventStore;

use EventCentric\When\ConventionBased\ConventionBasedWhenUnderstands;

abstract class Projection implements EventDispatcher
{
    use ConventionBasedWhenUnderstands;

    public function dispatch(DispatchableDomainEvent $dispatchableDomainEvent)
    {
        $this->whenUnderstands($dispatchableDomainEvent->domainEvent());
    }
}
