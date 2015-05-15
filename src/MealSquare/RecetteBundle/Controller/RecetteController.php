<?php

namespace MealSquare\RecetteBundle\Controller;

use MealSquare\RecetteBundle\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecetteController extends Controller {

    public function listAction(Request $request) {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM MealSquareRecetteBundle:Recette a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $request->query->get('page', 1)/* page number */, 20/* limit per page */
        );

        // parameters to template
        return $this->render('MealSquareRecetteBundle:Recette:list.html.twig', array('pagination' => $pagination));
    }

    public function showAction($id) {
        $repository = $this->getDoctrine()
                ->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        return $this->render('MealSquareRecetteBundle:Recette:show.html.twig', array('recette' => $recette));
    }

}
