<?php

namespace Dflydev\EventStore;

class FollowStoreDispatcher
{
    public function notifyEventDispatchers(EventStore $eventStore, $lastDispatchedEventId, array $eventDispatchers = [])
    {
        $undispatchedEvents = $eventStore->eventsSince($lastDispatchedEventId);

        foreach ($undispatchedEvents as $dispatchableDomainEvent) {
            foreach ($eventDispatchers as $eventDispatcher) {
                $eventDispatcher->dispatch($dispatchableDomainEvent);
            }
            $lastDispatchedEventId = $dispatchableDomainEvent->eventId();
        }

        return $lastDispatchedEventId;
    }
}
