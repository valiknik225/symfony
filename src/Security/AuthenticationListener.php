<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\AuthenticatorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AuthenticationListener implements AuthenticatorInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserProviderInterface $userProvider,
        private TokenStorageInterface $tokenStorage,
        private SessionInterface $session
    ) {}

    public function supports(Request $request): ?bool
    {
        return $request->attributes->get('_route') === 'app_login' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');

        if (!$email) {
            throw new AuthenticationException('Email is required.');
        }

        $user = $this->userProvider->loadUserByIdentifier($email);

        if (!$user) {
            throw new AuthenticationException('Invalid credentials.');
        }

        if (!$user->isValidPassword($password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        return new Passport($user, new PasswordCredentials($password));
    }


    public function createToken(Passport $passport, string $firewallName): TokenInterface
    {
        return new PostAuthenticationToken($passport->getUser(), $firewallName, $passport->getUser()->getRoles());
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new Response($this->session->get('_security.' . $firewallName . '.target_path') ?: '/');
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->getFlashBag()->add('error', $exception->getMessage());
        return new Response('/login');
    }
}
