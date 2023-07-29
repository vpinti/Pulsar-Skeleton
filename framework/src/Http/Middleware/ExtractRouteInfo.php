<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Http\HttpException;
use Pulsar\Framework\Http\HttpRequestMethodException;


class ExtractRouteInfo implements MiddlewareInterface
{

    public function __construct(private array $routes)
    {
    }
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        // Create a dispatcher
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            foreach($this->routes as $route) {
                $routeCollector->addRoute(...$route);
            }
        });

        // Dispatch a URI, to obtain the route info
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        switch($routeInfo[0]) {
            case Dispatcher::FOUND:
                $request->setRouteHandler($routeInfo[1]);
                $request->setRouteHandlerArgs($routeInfo[2]);

                // Inject route middleware on handler
                if(is_array($routeInfo[1]) && isset($routeInfo[1][2])) {
                    $requestHandler->injectMiddleware($routeInfo[1][2]);
                }
                break;
                // return [$routeInfo[1], $routeInfo[2]]; // routeHandler, vars
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethos = implode(', ', $routeInfo[1]);
                $e = new HttpRequestMethodException("The allowed methods are $allowedMethos");
                $e->setStatusCode(405);
                throw $e;
            default:
                $e = new HttpException('Not Found');
                $e->setStatusCode(404);
                throw $e;
        }
        
        return $requestHandler->handle($request);
    }
}