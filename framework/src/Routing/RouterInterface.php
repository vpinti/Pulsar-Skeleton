<?php

declare(strict_types=1);

namespace Pulsar\Framework\Routing;

use Pulsar\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request): array;
}