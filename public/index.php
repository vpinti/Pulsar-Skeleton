<?php 

declare(strict_types=1);

use Pulsar\Framework\Http\Kernel;
use Pulsar\Framework\Http\Request;

define('BASE_PATH', dirname(__DIR__));

require_once BASE_PATH . '/vendor/autoload.php';

$container = require BASE_PATH . '/config/services.php';

$eventDispatcher = $container->get(\Pulsar\Framework\EventDispatcher\EventDispatcher::class);
$eventDispatcher
    ->addListener(
        \Pulsar\Framework\Http\Event\ResponseEvent::class,
        new \App\EventListener\InternalErrorListener()
    )
    ->addListener(
        \Pulsar\Framework\Http\Event\ResponseEvent::class,
        new \App\EventListener\ContentLengthListener()
);

// request received
$request = Request::createFromGlobals();

// send response (string of content)
$kernel = $container->get(Kernel::class);

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);