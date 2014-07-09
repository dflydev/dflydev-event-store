<?php

namespace JsonEventSerializerTest;

require_once __DIR__.'/bootstrap.php';

use Dflydev\EventStore\Implementations\JsonEventSerializer;
use EventCentric\DomainEvents\DomainEvent;
use JsonSerializable;

class TestJsonEventSerializer extends JsonEventSerializer
{
    public function deserialize($data, $className)
    {
        return $className::jsonDeserialize(json_decode($data, true));
    }
}

class TestJsonSerialization implements DomainEvent, JsonSerializable
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

    public function jsonSerialize()
    {
        return ['contrived', $this->value];
    }

    public static function jsonDeserialize($data)
    {
        if ('contrived' !== $data[0]) {
            throw new \RuntimeException('Invalid JSON serialization format detected');
        }

        return new static($data[1]);
    }
}

$eventSerializer = new TestJsonEventSerializer();

$one = new TestJsonSerialization('one');
$two = new TestJsonSerialization('two');

$oneSerialized = $eventSerializer->serialize($one);
$twoSerialized = $eventSerializer->serialize($two);

$oneDeserialized = $eventSerializer->deserialize(
    $oneSerialized,
    'JsonEventSerializerTest\TestJsonSerialization'
);

$twoDeserialized = $eventSerializer->deserialize(
    $twoSerialized,
    'JsonEventSerializerTest\TestJsonSerialization'
);

it('should have the a value of "one"', 'one' === $oneDeserialized->value());
it('should have the a value of "two"', 'two' === $twoDeserialized->value());
