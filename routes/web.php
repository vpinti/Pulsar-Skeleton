<?php

declare(strict_types=1);

use Pulsar\Framework\Http\Response;

return [
    ['GET', '/', [\App\Controller\HomeController::class, 'index']],
    ['GET', '/posts/{id:\d+}', [\App\Controller\PostsController::class, 'show']],
    ['GET', '/posts', [\App\Controller\PostsController::class, 'create']],
    ['POST', '/posts', [\App\Controller\PostsController::class, 'store']],
    ['GET', '/register', [\App\Controller\RegistrationController::class, 'index', 
        [
            \Pulsar\Framework\Http\Middleware\Guest::class,
        ]
    ]],
    ['POST', '/register', [\App\Controller\RegistrationController::class, 'register']],
    ['GET', '/login', [\App\Controller\LoginController::class, 'index',
        [
            \Pulsar\Framework\Http\Middleware\Guest::class,
        ]
    ]],
    ['POST', '/login', [\App\Controller\LoginController::class, 'login']],
    ['GET', '/logout', [\App\Controller\LoginController::class, 'logout',
    [
        \Pulsar\Framework\Http\Middleware\Authenticate::class,
    ]
    ]],
    ['GET', '/dashboard', [\App\Controller\DashboardController::class, 'index', 
        [
            \Pulsar\Framework\Http\Middleware\Authenticate::class,
            \Pulsar\Framework\Http\Middleware\Dummy::class
        ]
    ]],
    ['GET', '/hello/{name:.+}', function(string $name) {
        return new Response("Hello $name");
    }]
];