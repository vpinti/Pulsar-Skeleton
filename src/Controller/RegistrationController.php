<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\User\RegistrationForm;
use App\Repository\UserMapper;
use Pulsar\Framework\Controller\AbstractController;
use Pulsar\Framework\Http\RedirectResponse;
use Pulsar\Framework\Http\Response;

class RegistrationController extends AbstractController
{
    public function __construct(private UserMapper $userMapper)
    {
    }
    
    public function index(): Response
    {   
        return $this->render('register.html.twig');
    }

    public function register(): Response
    {
        $form = new RegistrationForm($this->userMapper);

        $form->setFields(
            $this->request->input('username'),
            $this->request->input('password')
        );

        if($form->hasValidationErrors()) {
            foreach($form->getValidationErrors() as $error) {
                $this->request->getSession()->setFlash('error', $error);
            }

            return new RedirectResponse('/register');
        }

        $user = $form->save();

        $this->request->getSession()->setFlash(
            'success',
            sprintf('User %s created', $user->getUsername())
        );

        return new RedirectResponse('/');
    }
}