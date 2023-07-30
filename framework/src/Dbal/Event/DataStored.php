<?php

declare(strict_types=1);

namespace Pulsar\Framework\Dbal\Event;

use Pulsar\Framework\Dbal\Entity;
use Pulsar\Framework\EventDispatcher\Event;

class DataStored extends Event
{
    public function __construct(private Entity $subject)
    {
    }
}