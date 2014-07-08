<?php

namespace DakotaTrackside\Common\Event\Sourcing;

interface VersionMutates
{
    public function mutatedVersion();
    public function unmutatedVersion();
    public function mutateFrom($unmutatedVersion);
}
