<?php

namespace FollowStoreDispatcherTest;

require_once __DIR__.'/bootstrap.php';

use Dflydev\EventStore\DispatchableDomainEvent;
use Dflydev\EventStore\EventDispatcher;
use Dflydev\EventStore\EventStore;
use Dflydev\EventStore\EventStreamId;
use Dflydev\EventStore\FollowStoreDispatcher;
use EventCentric\DomainEvents\DomainEvent;
use EventCentric\DomainEvents\DomainEvents;

class TestEventStore implements EventStore
{
    private $eventsSinceResponses = [];
    private $eventsSinceResponsesIndex = 0;

    public function __construct(array $eventsSinceResponses = [])
    {
        $this->eventsSinceResponses = $eventsSinceResponses;
    }
    public function appendWith(EventStreamId $eventStreamId, DomainEvents $domainEvents)
    {
        throw new \RuntimeException("Not implemented.");
    }

    public function eventStreamSince(EventStreamId $eventStreamId)
    {
        throw new \RuntimeException("Not implemented.");
    }

    public function fullEventStreamFor(EventStreamId $eventStreamId)
    {
        throw new \RuntimeException("Not implemented.");
    }

    public function eventsSince($lastReceivedEventId)
    {
        $expected = $this->eventsSinceResponses[$this->eventsSinceResponsesIndex++];

        if ($lastReceivedEventId !== $expected[0]) {
            throw new \RuntimeException("eventsSince received '".$lastReceivedEventId."' but expected '".$expected[0]."'");
        }

        return $expected[1];
    }
}

class TestDomainEvent implements DomainEvent
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}

class TestEventDispatcher implements EventDispatcher
{
    private $expectedValues = [];
    private $expectedValuesIndex = 0;

    public function __construct(array $expectedValues = [])
    {
        $this->expectedValues = $expectedValues;
    }

    public function dispatch(DispatchableDomainEvent $dispatchableDomainEvent)
    {
        $expected = $this->expectedValues[$this->expectedValuesIndex++];
        $actual = $dispatchableDomainEvent->domainEvent()->value();
        if ($actual !== $expected) {
            throw new \RuntimeException("dispatch received '".$actual."' but expected '".$expected."'");
        }
    }
}

$eventStore = new TestEventStore([
    [2, [new DispatchableDomainEvent(3, new TestDomainEvent('one'))]],
    [5, [
        new DispatchableDomainEvent(6, new TestDomainEvent('one')),
        new DispatchableDomainEvent(7, new TestDomainEvent('two')),
        new DispatchableDomainEvent(8, new TestDomainEvent('three')),
    ]],
    [10, []],
]);

$followStoreDispatcher = new FollowStoreDispatcher();

$eventDispatcher = function () {
    $args = func_get_args();

    return new TestEventDispatcher($args);
};

$lastDispatchedEventId = $followStoreDispatcher->notifyEventDispatchers(
    $eventStore, 2, [$eventDispatcher('one')]
);

it('should have the last dispatched event ID of 3', 3 === $lastDispatchedEventId);

$lastDispatchedEventId = $followStoreDispatcher->notifyEventDispatchers(
    $eventStore, 5, [$eventDispatcher('one', 'two', 'three')]
);

it('should have the last dispatched event ID of 8', 8 === $lastDispatchedEventId);

$lastDispatchedEventId = $followStoreDispatcher->notifyEventDispatchers(
    $eventStore, 10, [$eventDispatcher()]
);

it('should have the last dispatched event ID of 10', 10 === $lastDispatchedEventId);
