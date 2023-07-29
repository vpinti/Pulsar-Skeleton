<?php

namespace Pulsar\Framework\Authentication;

use Pulsar\Framework\Session\SessionInterface;

class SessionAuthentication implements SessionAuthInterface
{
    private AuthUserInterface $user;

    //TODO: Move in other place (maybe Session) to avoid tight coupling
    public const AUTH_KEY = 'auth_id';

    public function __construct(
        private AuthRepositoryInterface $authRepository,
        private SessionInterface $session
    )
    {
    }
    
    public function authenticate(string $username, string $password): bool
    {
        $user = $this->authRepository->findByUsername($username);

        if(!$user) {
            return false;
        }

        if(!password_verify($password, $user->getPassword())) {
            return false;
        }

        $this->login($user);

        return true;
    }

    public function login(AuthUserInterface $user)
    {
        $this->session->start();

        $this->session->set(self::AUTH_KEY, $user->getAuthId());

        $this->user = $user;
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;
    }

}