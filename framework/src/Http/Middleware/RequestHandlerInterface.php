<?php

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;

interface RequestHandlerInterface
{
    public function handle(Request $request): Response;
}