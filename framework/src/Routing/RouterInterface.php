<?php

declare(strict_types=1);

namespace Pulsar\Framework\Routing;

use Psr\Container\ContainerInterface;
use Pulsar\Framework\Http\Request;

interface RouterInterface
{
    public function dispatch(Request $request, ContainerInterface $container): array;
    public function setRoutes(array $routes): void;
}