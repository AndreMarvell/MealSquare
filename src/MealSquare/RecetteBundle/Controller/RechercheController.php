<?php

namespace MealSquare\RecetteBundle\Controller;

use MealSquare\RecetteBundle\Entity\Recette;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use MealSquare\RecetteBundle\Form\RecetteType;
use MealSquare\RecetteBundle\Form\RecetteEditType;
use Doctrine\Common\Util\Debug;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RechercheController extends Controller {

    public function findAction() {
        
        $form = $this->createForm(new \MealSquare\RecetteBundle\Form\RecetteSearchType());
        $request = $this->getRequest();

        if ($request->getMethod() == 'GET') {

            $form->bind($request);
            $data = $request->query->get('recipe_search');
            
              if ($form->isValid() && !is_null($data)) {
                $em = $this->getDoctrine()->getManager();
                $liste_recettes = $em->getRepository('MealSquareRecetteBundle:Recette')->findAnnonceByParametres($data);
                 
                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $liste_recettes, $request->query->get('page', 1)/* page number */, 20/* limit per page */
                );
                return $this->render('MealSquareRecetteBundle:Recherche:recherche.html.twig', array('pagination' => $pagination, 'form' => $form->createView()));
            }
        }
        
        
        
        return $this->render('MealSquareRecetteBundle:Recherche:recherche.html.twig', array('form'
                    => $form->createView()));
    }

}
