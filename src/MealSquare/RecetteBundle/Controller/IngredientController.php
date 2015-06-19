<?php

namespace MealSquare\RecetteBundle\Controller;

use MealSquare\RecetteBundle\Entity\Ingredient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends Controller {

    public function listAction(Request $request) {
//        $em = $this->get('doctrine.orm.entity_manager');
//        $dql = "SELECT a FROM MealSquareRecetteBundle:Ingredient a";
//        $query = $em->createQuery($dql);
        
        $query = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Ingredient")->findAll();
        $raccourcis = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Raccourci")->findBy(array('actif'=>true));

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', 1)/* page number */, 12/* limit per page */
        );

        // parameters to template
        return $this->render('MealSquareRecetteBundle:Ingredient:list.html.twig', array(
            'pagination' => $pagination,
            'raccourcis' => $raccourcis
        ));
    }

    public function showAction($id) {
        $repository = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Ingredient");
        $ingredient = $repository->findOneById($id);
        
        if(is_null($ingredient)){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            $recettes   = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Recette")->findByIngredient($ingredient->getLibelle());
            return $this->render('MealSquareRecetteBundle:Ingredient:show.html.twig', array(
                'ingredient' => $ingredient,
                'recettes' => $recettes
            ));
        }
    }

}
