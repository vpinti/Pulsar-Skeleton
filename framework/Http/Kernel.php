<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http;

use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Kernel
{
    public function handle(Request $request): Response
    {
        // Create a dispatcher
        $dispatcher = simpleDispatcher(function (RouteCollector $routeCollector) {
            
            $routes = include BASE_PATH . '/routes/web.php';
            
            foreach($routes as $route) {
                $routeCollector->addRoute(...$route);
            }

            // $routeCollector->addRoute('GET', '/posts/{id:\d+}', function($routeParams) {
            //     $content = "<h1>This is Post {$routeParams['id']}</h1>";
                
            //     return new Response($content);
            // });
        });

        // Dispatch a URI, to obtain the route info
        $routeInfo = $dispatcher->dispatch(
            $request->getMethod(),
            $request->getPathInfo()
        );

        [$status, [$controller, $method], $vars] = $routeInfo;

        $response = (new $controller())->$method($vars);

        // Call the handler, provided by the route info, in order to create a Response
        return $response;
    }
}