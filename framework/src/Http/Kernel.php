<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

use Psr\Container\ContainerInterface;
use Pulsar\Framework\Routing\RouterInterface;

class Kernel
{
    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    )
    {
    }
    
    public function handle(Request $request): Response
    {
        try {
            [$routeHanlder, $vars] = $this->router->dispatch($request, $this->container);

            $response = call_user_func_array($routeHanlder, $vars);

        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), $exception->getStatusCode());
        } 
        
        return $response;
    }
}