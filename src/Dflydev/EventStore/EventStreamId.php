<?php

namespace Dflydev\EventStore;

class EventStreamId
{
    private $streamName;
    private $streamVersion;

    public static function create($streamName, $streamVersion = 1)
    {
        return new static(
            is_array($streamName) ? implode(':', $streamName) : $streamName,
            $streamVersion
        );
    }

    private function __construct($streamName, $streamVersion)
    {
        $this->streamName = $streamName;
        $this->streamVersion = $streamVersion;
    }

    public function streamName()
    {
        return $this->streamName;
    }

    public function streamVersion()
    {
        return $this->streamVersion;
    }
}
