<?php 

declare(strict_types=1);

use Pulsar\Framework\Http\Kernel;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Routing\Router;

define('BASE_PATH', dirname(__DIR__));

require_once dirname(__DIR__) . '/vendor/autoload.php';

// request received
$request = Request::createFromGlobals();

$router = new Router();
// perform some logic

// send response (string of content)
$kernel = new Kernel($router);

$response = $kernel->handle($request);

$response->send();