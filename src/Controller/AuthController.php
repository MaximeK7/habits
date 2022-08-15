<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthController extends ApiController
{
    #[IsGranted("ROLE_ROOT")]
    #[Route('/register', name: 'register', methods: 'POST')]
    public function register(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): JsonResponse
    {
        $request = $this->transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');

        if (empty($username) || empty($password) || empty($email)){
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        $user = new User($username);
        $user->setPassword($hasher->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setUsername($username);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
    }

    #[Route('/api/login_check', name: 'api_login_check', methods: 'GET')]
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        return new JsonResponse(['token' => $jwtManager->create($user)]);
    }

}
