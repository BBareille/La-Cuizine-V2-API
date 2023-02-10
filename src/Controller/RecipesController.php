<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Repository\RecipesRepository;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class RecipesController extends AbstractController
{
    #[Route('/api/recipes', name: 'app_recipes')]
    public function getAllRecipes(RecipesRepository $recipesRepository, SerializerInterface $serializer): JsonResponse
    {
         $recipesList = $recipesRepository->findAll();
         $jsonRecipesList = $serializer->serialize($recipesList, 'json');

        return new JsonResponse($jsonRecipesList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/newRecipes/', name: 'newIngredient', methods: ['POST'])]
    public function newIngredient(Request $request,RecipesRepository $recipesRepository, SerializerInterface $serializer): JsonResponse
    {
        $test = $request->getBody();
        $jsontest = $serializer->serialize($test, 'json');
//        $newRecipes = new Recipes();
//        $newRecipes->setTitle($name);
//        $newRecipes->setUserId(1);
//        $recipesRepository->save($newRecipes, true);
//        $jsonNewRecipes = $serializer->serialize($newRecipes, 'json');

        return new JsonResponse($jsontest, Response::HTTP_OK, [], true);
    }
}
