<?php

namespace Dflydev\EventStore;

abstract class FollowStore implements EventNotifiable
{
    use EventDispatchers;
}
