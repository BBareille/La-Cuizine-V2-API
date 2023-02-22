<?php
namespace App\Controller;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class LoginController extends AbstractController
{
        
        #[Route('/api/login', name: 'api_login')]
    public function index(Security $security ,UserInterface $user,
                                  JWTTokenManagerInterface $JWTManager)
    {
            $security->login($user);
            $isLoggedIn = $security->isGranted('IS_AUTHENTICATED_FULLY',$user);
            $token = $JWTManager->create($user);
            
            
            
            return new JsonResponse([
                        'token' => $token,
                        'user' => $user->getUserIdentifier(),
                        'isLoggedIn' => $isLoggedIn,
                        ]);
    }
        #[Route('/api/logout', name: 'api_logout')]
    public function logout(Security $security, UserInterface $user): JsonResponse{
                $username = $user->getUserIdentifier();
                $security->logout($user);
                
                return new JsonResponse([
                            'usernameLogOut' => $username
                ]);
    }
}
