<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

use Psr\Container\ContainerInterface;
use Pulsar\Framework\Routing\RouterInterface;

class Kernel
{
    private string $appEnv;
    public function __construct(
        private RouterInterface $router,
        private ContainerInterface $container
    )
    {
        $this->appEnv = $this->container->get('APP_ENV');
    }
    public function handle(Request $request): Response
    {
        try {
            [$routeHanlder, $vars] = $this->router->dispatch($request, $this->container);
            $response = call_user_func_array($routeHanlder, $vars);
        } catch (\Exception $exception) {
            $response = $this->createExceptionResponse($exception);
        }
        
        return $response;
    }

    /**
     * @throws  \Exception $exception
     */
    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array($this->appEnv, ['dev', 'test'])) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }

        return new Response('Server error', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}