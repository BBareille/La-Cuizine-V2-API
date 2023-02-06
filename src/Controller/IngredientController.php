<?php

namespace App\Controller;

use App\Repository\IngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class IngredientController extends AbstractController
{
    #[Route('/api/ingredients', name: 'ingredient', methods: ['GET'])]
    public function getAllIngredients(IngredientsRepository $ingredientsRepository, SerializerInterface $serizalizer): JsonResponse
    {
        $ingredientList = $ingredientsRepository->findAll();
        $jsonIngredientList = $serizalizer ->serialize($ingredientList, 'json');

        return new JsonResponse($jsonIngredientList, Response::HTTP_OK, [], true);
    }
}
