<?php

declare(strict_types=1);

namespace App\EventListener;

use Pulsar\Framework\EventDispatcher\EventSubscriberInterface;
use Pulsar\Framework\Http\Event\ResponseEvent;

class ContentLengthListener implements EventSubscriberInterface
{
    public function __invoke(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (!array_key_exists('Content-Length', $response->getHeaders())) {
            $response->setHeader('Content-Length', strlen($response->getContent()));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [ResponseEvent::class => ContentLengthListener::class];
    }
}