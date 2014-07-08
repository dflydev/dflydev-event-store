<?php

namespace Dflydev\EventStore;

trait VersionMutating
{
    private $unmutatedVersion;

    public function mutatedVersion()
    {
        return $this->unmutatedVersion + 1;
    }

    public function unmutatedVersion()
    {
        return $this->unmutatedVersion;
    }

    public function mutateFrom($unmutatedVersion)
    {
        $this->unmutatedVersion = $unmutatedVersion;
    }
}
