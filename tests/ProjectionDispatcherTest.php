<?php

namespace ProjectionDispatcherTest;

require_once __DIR__.'/bootstrap.php';

use Dflydev\EventStore\DispatchableDomainEvent;
use Dflydev\EventStore\Projection;
use Dflydev\EventStore\ProjectionDispatcher;
use EventCentric\DomainEvents\DomainEvent;

abstract class ProjectionDispatcherTestDomainEvent implements DomainEvent
{
    abstract function value();
}
class ProjectionDispatcherTestFirstDomainEvent extends ProjectionDispatcherTestDomainEvent
{
    public function value() { return 'first'; }
}

class ProjectionDispatcherTestSecondDomainEvent extends ProjectionDispatcherTestDomainEvent
{
    public function value() { return 'second'; }
}

class ProjectionDispatcherTestThirdDomainEvent extends ProjectionDispatcherTestDomainEvent
{
    public function value() { return 'third'; }
}

abstract class ProjectionDispatcherTestProjection extends Projection
{
    private $values = [];
    public function pushValue($expectedValue, ProjectionDispatcherTestDomainEvent $event)
    {
        $this->values[] = [$expectedValue, $event->value()];
    }
    public function values() { return $this->values; }
}

class ProjectionDispatcherTestFirstProjection extends ProjectionDispatcherTestProjection
{
    protected function whenProjectionDispatcherTestFirstDomainEvent($event)
    {
        $this->pushValue('first', $event);
    }

    protected function understoodDomainEvents()
    {
        return [
            'ProjectionDispatcherTest\ProjectionDispatcherTestFirstDomainEvent'
        ];
    }
}

class ProjectionDispatcherTestSecondProjection extends ProjectionDispatcherTestProjection
{
    protected function whenProjectionDispatcherTestSecondDomainEvent($event)
    {
        $this->pushValue('second', $event);
    }

    protected function understoodDomainEvents()
    {
        return [
            'ProjectionDispatcherTest\ProjectionDispatcherTestSecondDomainEvent'
        ];
    }
}

class ProjectionDispatcherTestThirdProjection extends ProjectionDispatcherTestProjection
{
    protected function whenProjectionDispatcherTestThirdDomainEvent($event)
    {
        $this->pushValue('third', $event);
    }

    protected function understoodDomainEvents()
    {
        return [
            'ProjectionDispatcherTest\ProjectionDispatcherTestThirdDomainEvent'
        ];
    }
}

class ProjectionDispatcherTestCatchAllProjection extends ProjectionDispatcherTestProjection
{
    protected function whenProjectionDispatcherTestFirstDomainEvent($event)
    {
        $this->pushValue('first', $event);
    }

    protected function whenProjectionDispatcherTestSecondDomainEvent($event)
    {
        $this->pushValue('second', $event);
    }

    protected function whenProjectionDispatcherTestThirdDomainEvent($event)
    {
        $this->pushValue('third', $event);
    }

    protected function understoodDomainEvents()
    {
        return [
            'ProjectionDispatcherTest\ProjectionDispatcherTestDomainEvent'
        ];
    }
}

$firstProjection = new ProjectionDispatcherTestFirstProjection();
$secondProjection = new ProjectionDispatcherTestSecondProjection();
$thirdProjection = new ProjectionDispatcherTestThirdProjection();
$catchAllProjection = new ProjectionDispatcherTestCatchAllProjection();

$projectionDispatcher = new ProjectionDispatcher([
    $firstProjection,
    $secondProjection,
    $thirdProjection,
]);

$projectionDispatcher->registerProjection($catchAllProjection);

$projectionDispatcher->dispatch(new DispatchableDomainEvent(
    1, new ProjectionDispatcherTestFirstDomainEvent()
));

$projectionDispatcher->dispatch(new DispatchableDomainEvent(
    2, new ProjectionDispatcherTestSecondDomainEvent()
));

$projectionDispatcher->dispatch(new DispatchableDomainEvent(
    3, new ProjectionDispatcherTestThirdDomainEvent()
));

echo "Testing first projection results\n";
$firstProjectionValues = $firstProjection->values();
it('should have one value', 1 === count($firstProjectionValues));
it('should have expected value of "first"', 'first' === $firstProjectionValues[0][0]);
it('should have actual value of "first"', 'first' === $firstProjectionValues[0][1]);
echo "\n";

echo "Testing second projection results\n";
$secondProjectionValues = $secondProjection->values();
it('should have one value', 1 === count($secondProjectionValues));
it('should have expected value of "second"', 'second' === $secondProjectionValues[0][0]);
it('should have actual value of "second"', 'second' === $secondProjectionValues[0][1]);
echo "\n";

echo "Testing third projection results\n";
$thirdProjectionValues = $thirdProjection->values();
it('should have one value', 1 === count($thirdProjectionValues));
it('should have expected value of "third"', 'third' === $thirdProjectionValues[0][0]);
it('should have actual value of "third"', 'third' === $thirdProjectionValues[0][1]);
echo "\n";

echo "Testing catch all projection results\n";
$catchAllProjectionValues = $catchAllProjection->values();
it('should have three values', 3 === count($catchAllProjectionValues));
it('should have first expected value of "first"', 'first' === $catchAllProjectionValues[0][0]);
it('should have first actual value of "first"', 'first' === $catchAllProjectionValues[0][1]);
it('should have second expected value of "second"', 'second' === $catchAllProjectionValues[1][0]);
it('should have second actual value of "second"', 'second' === $catchAllProjectionValues[1][1]);
it('should have third expected value of "third"', 'third' === $catchAllProjectionValues[2][0]);
it('should have third actual value of "third"', 'third' === $catchAllProjectionValues[2][1]);
echo "\n";
