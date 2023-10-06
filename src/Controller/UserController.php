<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {
    #[Route('/users', name: 'app_users', methods:['GET'])]
    public function getAllUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        return new JsonResponse(['data' => $users],200);
    }

    #[Route('/users/{id}', name: 'app_user_id', methods:['GET'])]
    public function getUserById(UserRepository $userRepository, int $id): Response
    {
        $users = $userRepository->findOneBy(['id' => $id]);

        return new JsonResponse(['data' => $users],200);
    }

}