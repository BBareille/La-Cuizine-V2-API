<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Entity\User;
use App\Repository\RecipesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Tests\Compiler\J;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

class RecipesController extends AbstractController
{
    #[Route('/api/recipes', name: 'app_recipes')]
    public function getAllRecipes(RecipesRepository $recipesRepository, SerializerInterface $serializer): JsonResponse
    {
         $recipesList = $recipesRepository->findAll();
         $jsonRecipesList = $serializer->serialize($recipesList, 'json');

        return new JsonResponse($jsonRecipesList, Response::HTTP_OK, [], true);
    }
    

    #[Route('/api/newRecipes', name: 'newRecipes', methods: ['POST'])]
    public function newRecipe(Request $request,RecipesRepository $recipesRepository, SerializerInterface $serializer): JsonResponse
    {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
          $data = json_decode($request->getContent(), true);
          $newRecipes = new Recipes();
        $newRecipes
            ->setTitle($data['title'])
            ->setImage($data['image'])
            ->setCookingTime($data['cooking_time'])
            ->setPrepTime($data['prep_time']);

        $newRecipes->setUserId(1);
        $recipesRepository->save($newRecipes, true);
        $jsonData = $serializer->serialize($data, 'json');

        return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
    }
        
        #[Route('/api/modifyRecipe', name:'modifyRecipe', methods: ['PUT'])]
        public function modifyRecipe( Request $request,
                                      RecipesRepository $recipesRepository,
                                      SerializerInterface $serializer):JsonResponse{
                
                $data = json_decode($request->getContent(), true);
                $recipeToUpdate = $recipesRepository->findOneBy
                (["id"=>$data['id']]);
                
                $recipeToUpdate
                            ->setTitle($data['title'])
                            ->setImage($data['image'])
                            ->setCookingTime($data['cookingTime'])
                            ->setPrepTime($data['prepTime']);
                
                $recipeToUpdate->setUserId(1);
                $recipesRepository->save($recipeToUpdate, true);
                $jsonData = $serializer->serialize($data, 'json');
                
                return new JsonResponse($jsonData, Response::HTTP_OK, [], true);
        }

      #[Route('/api/deleteRecipe/{id}', name: 'deleteRecipes', methods: ['DELETE'])]
      public function deleteRecipe(int $id, RecipesRepository
      $recipesRepository, SerializerInterface $serizalizer, Request $request,
                                   Security $security, UserInterface $user){
            
                $security->login($user);
            $recipeToDelete = $recipesRepository->findOneBy(["id"=>$id]);
            $recipesRepository->remove($recipeToDelete, true);
            $jsonRecipeToDelete = $serizalizer->serialize($recipeToDelete, 'json');


            return new JsonResponse($jsonRecipeToDelete, Response::HTTP_OK, [], true);
      }

      #[Route('/api/recipe/{id}', name:'getOneRecipe', methods: ['GET'])]
      public function getOneRecipebyID(int $id, RecipesRepository $recipesRepository, SerializerInterface $serializer){
          $recipe = $recipesRepository->findOneBy(['id'=>$id]);
          $jsonRecipe = $serializer->serialize($recipe, 'json');

          return new JsonResponse($jsonRecipe, Response::HTTP_OK, [], true);
      }
      
      
      #[Route('/api/searchRecipe/{title}', name: 'searchRecipe', methods: ['GET'])]
      public function searchRecipes($title,RecipesRepository
      $recipesRepository, SerializerInterface $serializer){
            
            if(empty($title)){
                    $emptyJson = "";
                    $emptyJson = $serializer->serialize($emptyJson);
                return new JsonResponse($emptyJson, Response::HTTP_OK, [], true);
                
            }
            
            $recipesToFind = $recipesRepository->findRecipe($title);
            
            $recipesToFind = array_map(function ($recipes){
                    return $recipes->getTitle();
            },$recipesToFind);
            
            $jsonRecipe = $serializer->serialize($recipesToFind, 'json');
            
            return new JsonResponse($jsonRecipe, Response::HTTP_OK, [], true);
      }
}
