<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'api_login')]
    public function loginApi(#[CurrentUser] ?User $user): Response
    {
        if (null === $user) {
            return $this->json(['message' => 'missing credentials'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'id' => $user->getId(),
            'email'  => $user->getEmail(),
            'roles'  => $user->getRoles(),
        ]);
    }

    #[Route(path: '/login-form', name: 'app_login')]
    public function loginForm(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(#[CurrentUser] ?User $user): Response
    {
        return $this->json([
            'id' => $user->getId(),
            'email'  => $user->getEmail(),
            'roles'  => $user->getRoles(),
        ]);
    }
}
