<?php 

declare(strict_types=1);

use Pulsar\Framework\Http\Kernel;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// request received
$request = Request::createFromGlobals();

// perform some logic

// send response (string of content)
$kernel = new Kernel();

$response = $kernel->handle($request);

$response->send();