<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

use Pulsar\Framework\Routing\Router;

class Kernel
{
    public function __construct(private Router $router)
    {
    }
    
    public function handle(Request $request): Response
    {
        try {
            [$routeHanlder, $vars] = $this->router->dispatch($request);

            $response = call_user_func_array($routeHanlder, $vars);

        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 400);
        }

        return $response;
    }
}