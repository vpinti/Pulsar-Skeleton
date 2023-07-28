<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Session\SessionInterface;

class StartSession implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session)
    {
    }
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();

        $request->setSession($this->session);

        return $requestHandler->handle($request);
    }
}