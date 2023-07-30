<?php

declare(strict_types=1);

namespace Pulsar\Framework\Dbal;

use Doctrine\DBAL\Connection;
use Pulsar\Framework\Dbal\Event\DataStored;
use Pulsar\Framework\EventDispatcher\EventDispatcher;

class DataMapper
{
    public function __construct(
        private Connection $connection,
        private EventDispatcher $eventDispatcher
    )
    {
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function save(Entity $subject): int|string|null
    {
        // Dispatch DataStored event
        $this->eventDispatcher->dispatch(new DataStored($subject));

        // Return lastInsertId
        return $this->connection->lastInsertId();
    }
}