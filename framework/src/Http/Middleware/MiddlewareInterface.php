<?php

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;

interface MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response;
}