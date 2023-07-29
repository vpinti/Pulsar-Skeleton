<?php

declare(strict_types=1);

namespace App\Controller;

use Pulsar\Framework\Authentication\SessionAuthentication;
use Pulsar\Framework\Controller\AbstractController;
use Pulsar\Framework\Http\RedirectResponse;
use Pulsar\Framework\Http\Response;

class LoginController extends AbstractController
{
    public function __construct(private SessionAuthentication $authComponent)
    {
    }
    
    public function index(): Response
    {   
        return $this->render('login.html.twig');
    }

    public function login(): Response
    {
        $userIsAuthenticated = $this->authComponent->authenticate(
            $this->request->input('username'),
            $this->request->input('password')
        );

        if(!$userIsAuthenticated) {
            $this->request->getSession()->setFlash('error', 'Bad creds');
            return new RedirectResponse('/login');
        }
        
        $user = $this->authComponent->getUser();

        $this->request->getSession()->setFlash('success', 'You are now logged in');

        return new RedirectResponse('/dashboard');
    }
}