<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

use Pulsar\Framework\Routing\RouterInterface;

class Kernel
{
    public function __construct(private RouterInterface $router)
    {
    }
    
    public function handle(Request $request): Response
    {
        try {
            [$routeHanlder, $vars] = $this->router->dispatch($request);

            $response = call_user_func_array($routeHanlder, $vars);

        } catch (HttpException $exception) {
            $response = new Response($exception->getMessage(), $exception->getStatusCode());
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), 500);
        }

        return $response;
    }
}