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
        
        #[Route('/api/userTest', name: 'login', methods: ['GET'])]
        public function connect(Request $request, UserRepository
        $userRepository, SerializerInterface $serializer, Security $security, UserPasswordHasherInterface $passwordHasher):
        JsonResponse{
                $data = json_decode($request->getContent(), true);
                
                $user = $userRepository->findOneBy(array("username" => $data['username']));
                $hashedPassword = $passwordHasher->hashPassword(
                            $user,
                            $data['password']
                );
                
                var_dump($hashedPassword);
                var_dump($user->getPassword());
                if($hashedPassword == $user->getPassword()){
                        var_dump('ok');
                }
                else{
                        var_dump("wrong credentials");
                }
                
//                $securityTest = $security->login($user);
                $jsonData = $serializer->serialize($user->getUsername(), 'json');
                return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        }
}