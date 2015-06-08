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

    public function findAction(Request $request) {
        $form = $this->createForm(new \MealSquare\RecetteBundle\Form\RecetteSearchType());
        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {

            $form->bind($request);
           
              if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $data = $this->getRequest()->request->get('recette_search_type'); 
                $liste_recettes = $em->getRepository('MealSquareRecetteBundle:Recette')->findAnnonceByParametres($data);
 
                 
                 $paginator = $this->get('knp_paginator');
                 $pagination = $paginator->paginate(
                 $liste_recettes, $request->query->get('page', 1)/* page number */, 20/* limit per page */
        );
                return $this->render('MealSquareRecetteBundle:Recette:list.html.twig', array('pagination' => $pagination));
            }
        }
        return $this->render('MealSquareRecetteBundle:Recherche:recherche.html.twig', array('form'
                    => $form->createView()));
    }

}
