<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use Psr\Container\ContainerInterface;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Routing\RouterInterface;

class RouterDispatch implements MiddlewareInterface
{
    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    )
    {
    }
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        [$routeHanlder, $vars] = $this->router->dispatch($request, $this->container);
        
        $response = call_user_func_array($routeHanlder, $vars);

        return $response;
    }
}