<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use PharIo\Manifest\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\EmailValidator;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $repository): Response
    {
        $user = new User();
        $request = json_decode($request->getContent());

        if($request->email === null || $request->password === null  || $request->firstName === null  || $request->lastName === null  || $request->locality === null){
            return new JsonResponse(['message' => 'Missing request data'],400);
        }

        #TODO: Check the validity of given information

        $user->setEmail($request->email);
        $user->setPassword($userPasswordHasher->hashPassword($user, $request->password));
        $user->setFirstName($request->firstName);
        $user->setSecondName(!empty($request->secondName) ? $request->secondName : null);
        $user->setLastName($request->lastName);
        $user->setLocality($request->locality);

        if($repository->findOneBy(['email' => $request->email])){
                return new JsonResponse(['message' => 'User With This Email Already Exists'], 302);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['data' => $request, 'message' => 'User Successfully Registered'],200);
    }
}
