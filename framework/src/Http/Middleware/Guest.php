<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\RedirectResponse;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Session\Session;
use Pulsar\Framework\Session\SessionInterface;

class Guest implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session)
    {
    } 
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();
        
        if($this->session->has(Session::AUTH_KEY)) {
            //in laravel or symfony if a route has guest middleware 
            // and the user is logged in, it is returned to the last 
            // visited route. For convenience we force the route to dashboard
            return new RedirectResponse('/dashboard');
        }

        return $requestHandler->handle($request);
    }
}