<?php

declare(strict_types=1);

namespace Pulsar\Framework\Routing;

use FastRoute\Dispatcher;
use Pulsar\Framework\Http\Request;
use FastRoute\RouteCollector;
use Pulsar\Framework\Http\HttpException;
use Pulsar\Framework\Http\HttpRequestMethodException;

use function FastRoute\simpleDispatcher;

class Router implements RouterInterface
{
    public function dispatch(Request $request): array
    {
        $routeInfo = $this->extractRouteInfo($request);
        
        [$handler, $vars] = $routeInfo;

        if(is_array($handler)) {
            [$controller, $method] = $handler;
            $handler = [new $controller, $method];
        }
        

        return [$handler, $vars];
    }

    private function extractRouteInfo(Request $request): array
    {
        // Create a dispatcher
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
    
            $routes = include BASE_PATH . '/routes/web.php';
            
            foreach($routes as $route) {
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
                return [$routeInfo[1], $routeInfo[2]]; // routeHandler, vars
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethos = implode(', ', $routeInfo[1]);
                throw new HttpRequestMethodException("The allowed methods are $allowedMethos");
            default:
                throw new HttpException('Not Found');
        }
    }
}