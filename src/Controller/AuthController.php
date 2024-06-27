<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $plainPassword = $request->request->get('plainPassword');

            if ($email && $plainPassword) {
                $user = new User($email, $plainPassword);
                $user->changePassword($plainPassword, $userPasswordHasher);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('app_mainapp');
            }
        }

        return $this->render('auth/register.html.twig');
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    /*#[Route(path: '/login', name: 'app_login')]
    public function login(Security $security): Response
    {
        if ($security->getUser()) {
            return $this->redirectToRoute('app_mainapp');
        }

        return $this->render('auth/login.html.twig', [
            // Add any necessary variables here
        ]);
    }*/

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
