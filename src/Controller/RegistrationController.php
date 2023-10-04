<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $user = new User();

        $request = json_decode($request->getContent());

        $user->setEmail($request->email);
        $user->setPassword($userPasswordHasher->hashPassword($user, $request->password));

        if($repository->findOneByEmail($user->getEmail()) != null){
            return new JsonResponse(['message' => 'User With This Email Already Exists'],302);
        }

        $entityManager->persist($user);
        $entityManager->flush();


        #TODO: Check if email is already in database

        return new JsonResponse(['request'=>$request, 'message' => 'User Successfully Registered'],200);
    }
}
