<?php

namespace App\Controller;

use App\Entity\Ingredients;
use App\Repository\IngredientsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

class IngredientController extends AbstractController
{
    #[Route('/api/ingredients', name: 'ingredient', methods: ['GET'])]
    public function getAllIngredients(IngredientsRepository $ingredientsRepository, SerializerInterface $serizalizer): JsonResponse
    {
        $ingredientList = $ingredientsRepository->findAll();
        $jsonIngredientList = $serizalizer ->serialize($ingredientList, 'json');

        return new JsonResponse($jsonIngredientList, Response::HTTP_OK, [], true);
    }

    #[Route('/api/newIngredient/{data}', name: 'newIngredient', methods: ['POST'])]
    public function newIngredient($data,Request $request,
                                  IngredientsRepository
    $ingredientsRepository, SerializerInterface $serizalizer): JsonResponse
    {
        $newIngredient = new Ingredients();
        $newIngredient->setName($data);
        $ingredientsRepository->save($newIngredient, true);
        $jsonNewIngredient = $serizalizer->serialize($newIngredient, 'json');

        return new JsonResponse($jsonNewIngredient, Response::HTTP_OK, [], true);
    }

    #[Route('/api/deleteIngredient/{id}', name: 'deleteIngredient', methods: ['DELETE'])]
    public function deleteIngredient(int $id, IngredientsRepository $ingredientsRepository, SerializerInterface $serizalizer){
        
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $ingredientToDelete = $ingredientsRepository->findOneBy(["id"=>$id]);
        $ingredientsRepository->remove($ingredientToDelete, true);
        $jsonIngredientToDelete = $serizalizer->serialize($ingredientToDelete, 'json');


        return new JsonResponse($jsonIngredientToDelete, Response::HTTP_OK, [], true);
    }
    #[Route('/api/updateIngredient/{id}/{newName}', name: 'modifyIngredient', methods: ['PUT'])]
    public function updateIngredient(int $id,string $newName, IngredientsRepository $ingredientsRepository, SerializerInterface $serializer){
        
            $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
            
            $ingredientToUpdate = $ingredientsRepository->findOneBy(["id"=>$id]);
        $ingredientToUpdate->setName($newName);
        $ingredientsRepository->save($ingredientToUpdate, true);
        $jsonIngredientToUpdate = $serializer->serialize($ingredientToUpdate, 'json');

        return new JsonResponse($jsonIngredientToUpdate, Response::HTTP_OK, [], true);

    }



}
