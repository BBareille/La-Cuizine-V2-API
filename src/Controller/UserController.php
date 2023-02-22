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
                        ->setPassword($hashedPassword)
                        ->setRoles(["ROLE_USER"]);
                
                $userRepository->save($newUser, true);
                $jsonData = $serializer->serialize($data, 'json');
                
                return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
                
        }
        
        
}