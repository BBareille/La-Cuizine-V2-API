<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (null === $user){
                return $this->json([
                            'message' => 'missing Credentials',
                ]);
        }
        
        return $this->json([
                    'user' => $user->getUserIdentifier(),
                'message' => 'Connexion réussie'
        ]);
    }
}
