<?php

namespace EventStreamIdTest;

use Dflydev\EventStore\EventStreamId;

require_once __DIR__.'/bootstrap.php';

function runTest($description, EventStreamId $eventStreamId, $expectedStreamName, $expectedStreamVersion)
{
    echo $description."\n";
    it('should have the name "'.$expectedStreamName.'"', $expectedStreamName === $eventStreamId->streamName());
    it('should have the version "'.$expectedStreamVersion.'"', $expectedStreamVersion === $eventStreamId->streamVersion());
    echo "\n";
}

runTest('Testing simple name plus default version', EventStreamId::create('one'), 'one', 1);
runTest('Testing simple name plus explicit version', EventStreamId::create('one', 1337), 'one', 1337);
runTest('Testing complex name name plus explicit version', EventStreamId::create(['one'], 1337), 'one', 1337);
runTest('Testing compound name name plus explicit version', EventStreamId::create(['one', 'two'], 1337), 'one:two', 1337);
