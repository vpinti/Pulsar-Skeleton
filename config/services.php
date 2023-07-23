<?php

$container = new League\Container\Container();

$container->add(
    Pulsar\Framework\Routing\RouterInterface::class,
    Pulsar\Framework\Routing\Router::class,
);

$container->add(\Pulsar\Framework\Http\Kernel::class)
    ->addArgument(Pulsar\Framework\Routing\RouterInterface::class);

return $container;
