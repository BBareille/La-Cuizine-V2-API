<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
class UserController extends AbstractController
{
        #[Route('/api/newUser', name: 'newUser', methods: ['POST'])]
        public function newUser(Request $request,UserRepository
        $userRepository, SerializerInterface $serializer, UserPasswordHasherInterface $passwordHasher):
        JsonResponse{
                $data = json_decode($request->getContent(), true);
                $newUser = new User();
                
                $hashedPassword = $passwordHasher->hashPassword(
                            $newUser,
                            $data['password']
                );
                $newUser->setUsername($data['username'])
                        ->setPassword($hashedPassword);
                
                
                $userRepository->save($newUser, true);
                $jsonData = $serializer->serialize($data, 'json');
                
                return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
                
        }
        
        #[Route('/api/login', name: 'api_login')]
        public function index(#[CurrentUser] ?User $user): Response
        {
         if (null === $user) {
                           return $this->json([
                                             'message' => 'missing credentials',
                                        ], Response::HTTP_UNAUTHORIZED);
         }

        $token = "";// somehow create an API token for $user
          return $this->json([
                      'message' => 'Welcome to your new controller!',
                      'path' => 'src/Controller/ApiLoginController.php',
                      'user'  => $user->getUserIdentifier(),
                      'token' => $token,
          ]);
      }
}