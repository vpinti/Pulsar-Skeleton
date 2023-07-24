<?php

$container = new League\Container\Container();
$container->delegate(new League\Container\ReflectionContainer(true));

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(BASE_PATH . '/.env');

# parameters for application config
$routes = include BASE_PATH . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = BASE_PATH . '/templates';

$container->add('APP_ENV', new \League\Container\Argument\Literal\StringArgument($appEnv));

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

$container->addShared('filesystem-loader', \Twig\Loader\FilesystemLoader::class)
    ->addArgument(new \League\Container\Argument\Literal\StringArgument($templatesPath));

$container->addShared(\Twig\Environment::class)
    ->addArgument('filesystem-loader');

return $container;
