<?php

$container = new League\Container\Container();
$container->delegate(new League\Container\ReflectionContainer(true));

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';

# services

$container->add(
    Pulsar\Framework\Routing\RouterInterface::class,
    Pulsar\Framework\Routing\Router::class,
);

$container->extend(Pulsar\Framework\Routing\RouterInterface::class)
    ->addMethodCall(
        'setRoutes',
        [new League\Container\Argument\Literal\ArrayArgument($routes)]
    );

$container->add(\Pulsar\Framework\Http\Kernel::class)
    ->addArgument(Pulsar\Framework\Routing\RouterInterface::class)
    ->addArgument($container);

return $container;
