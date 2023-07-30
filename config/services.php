<?php

$container = new League\Container\Container();
$container->delegate(new League\Container\ReflectionContainer(true));

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

# parameters for application config
$basePath = dirname(__DIR__);
$container->add('basePath', new \League\Container\Argument\Literal\StringArgument($basePath));
$routes = include $basePath . '/routes/web.php';
$appEnv = $_SERVER['APP_ENV'];
$templatesPath = $basePath . '/templates';

$container->add('APP_ENV', new League\Container\Argument\Literal\StringArgument($appEnv));
$databaseUrl = 'sqlite:///' . $basePath . '/var/db.sqlite';

$container->add(
    'base-commands-namespace',
    new \League\Container\Argument\Literal\StringArgument('Pulsar\\Framework\\Console\\Command\\')
);

# services

$container->add(
    Pulsar\Framework\Routing\RouterInterface::class,
    Pulsar\Framework\Routing\Router::class,
);

$container->add(
    \Pulsar\Framework\Http\Middleware\RequestHandlerInterface::class,
    \Pulsar\Framework\Http\Middleware\RequestHandler::class
)->addArgument($container);

$container->addShared(\Pulsar\Framework\EventDispatcher\EventDispatcher::class);

$container->add(\Pulsar\Framework\Http\Kernel::class)
    ->addArguments([
        $container,
        \Pulsar\Framework\Http\Middleware\RequestHandlerInterface::class,
        \Pulsar\Framework\EventDispatcher\EventDispatcher::class
    ]);

$container->add(\Pulsar\Framework\Console\Application::class)
    ->addArgument($container);

$container->add(\Pulsar\Framework\Console\Kernel::class)
    ->addArguments([$container, \Pulsar\Framework\Console\Application::class]);

$container->addShared(
    \Pulsar\Framework\Session\SessionInterface::class,
    \Pulsar\Framework\Session\Session::class
);

$container->add('template-render-factory', \Pulsar\Framework\Template\TwigFactory::class)
    ->addArguments([
        \Pulsar\Framework\Session\SessionInterface::class,
        new League\Container\Argument\Literal\StringArgument($templatesPath)
    ]);

$container->addShared('twig', function() use ($container) {
    return $container->get('template-render-factory')->create();
});

$container->add(Pulsar\Framework\Controller\AbstractController::class);
$container->inflector(Pulsar\Framework\Controller\AbstractController::class)
    ->invokeMethod('setContainer', [$container]);

$container->add(\Pulsar\Framework\Dbal\ConnectionFactory::class)
    ->addArguments([
        new League\Container\Argument\Literal\StringArgument($databaseUrl)
    ]);

$container->addShared(\Doctrine\DBAL\Connection::class, function () use ($container): \Doctrine\DBAL\Connection {
    return $container->get(\Pulsar\Framework\Dbal\ConnectionFactory::class)->create();
});

$container->add(
    'database:migrations:migrate',
    \Pulsar\Framework\Console\Command\MigrateDatabase::class
)->addArguments([
    \Doctrine\DBAL\Connection::class,
    new League\Container\Argument\Literal\StringArgument($basePath . '/migrations')
]);

$container->add(\Pulsar\Framework\Http\Middleware\RouterDispatch::class)
    ->addArguments([
        \Pulsar\Framework\Routing\RouterInterface::class,
        $container
]);

$container->add(\Pulsar\Framework\Authentication\SessionAuthentication::class)
    ->addArguments([
        \App\Repository\UserRepository::class,
        \Pulsar\Framework\Session\SessionInterface::class
    ]);

$container->add(\Pulsar\Framework\Http\Middleware\ExtractRouteInfo::class)
    ->addArgument(new League\Container\Argument\Literal\ArrayArgument($routes));

return $container;
