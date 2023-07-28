<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;

class Authenticate implements MiddlewareInterface
{
    private bool $authenticated = true;
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        if(!$this->authenticated) {
            return new Response('Authentication failed', 401);
        }

        return $requestHandler->handle($request);
    }
}