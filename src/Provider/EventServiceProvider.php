<?php

declare(strict_types=1);

namespace App\Provider;

use App\EventListener\ContentLengthListener;
use App\EventListener\InternalErrorListener;
use Pulsar\Framework\Dbal\Event\DataStored;
use Pulsar\Framework\EventDispatcher\EventDispatcher;
use Pulsar\Framework\Http\Event\ResponseEvent;
use Pulsar\Framework\ServiceProvider\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listen = [
        ResponseEvent::class => [
            InternalErrorListener::class,
            ContentLengthListener::class
        ],
        DataStored::class => [
        ]
    ];

    public function __construct(private EventDispatcher $eventDispatcher)
    {
    }
    
    public function register(): void
    {
        // loop over each event in the listen array
        foreach ($this->listen as $eventName => $listeners) {
            // loop over each listener
            foreach (array_unique($listeners) as $listener) {
                // call eventDispatcher->addListener
                $this->eventDispatcher->addListener($eventName, new $listener());
            }
        }
    }
}