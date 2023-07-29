<?php

declare(strict_types=1);

namespace Pulsar\Framework\Http\Middleware;

use Pulsar\Framework\Http\RedirectResponse;
use Pulsar\Framework\Http\Request;
use Pulsar\Framework\Http\Response;
use Pulsar\Framework\Session\Session;
use Pulsar\Framework\Session\SessionInterface;

class Authenticate implements MiddlewareInterface
{
    public function __construct(private SessionInterface $session)
    {
    } 
    
    public function process(Request $request, RequestHandlerInterface $requestHandler): Response
    {
        $this->session->start();
        
        if(!$this->session->has(Session::AUTH_KEY)) {
            $this->session->setFlash('error', 'Please sign in');
            return new RedirectResponse('/login');
        }

        return $requestHandler->handle($request);
    }
}