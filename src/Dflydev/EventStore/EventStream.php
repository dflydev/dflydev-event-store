<?php

namespace Dflydev\EventStore;

interface EventStream
{
    public function domainEvents();
    public function version();
}
