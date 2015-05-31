<?php

namespace MealSquare\RecetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AsynchroneController extends Controller
{
    public function ingredientAction()
    {
        $request = $this->get('request');
 
        $term = $request->request->get('libelle');
        $array= $this->getDoctrine()
            ->getEntityManager()
            ->getRepository('MealSquareRecetteBundle:Ingredient')
            ->findIngredientsLike($term);

        $response = new Response(json_encode($array));
        $response -> headers -> set('Content-Type', 'application/json');
        
        return $response;
    }
}
