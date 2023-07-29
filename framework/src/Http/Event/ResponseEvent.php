<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Event;

use Pulsar\Framework\EventDispatcher\Event;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;

class ResponseEvent extends Event
{
    public function __construct(
        private Request $request,
        private Response $response
    )
    {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}