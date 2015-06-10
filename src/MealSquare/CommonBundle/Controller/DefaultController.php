<?php

namespace MealSquare\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MealSquare\RecetteBundle\Entity\Recette;

class DefaultController extends Controller {

    public function indexAction() {
        
        $em = $this->getDoctrine()->getManager();
        $recetteRepo = $em->getRepository('MealSquareRecetteBundle:Recette');
        $ingredientRepo = $em->getRepository('MealSquareRecetteBundle:Ingredient');
        $userRepo = $em->getRepository('ApplicationSonataUserBundle:User');
        $nbuser = $userRepo->createQueryBuilder('l')
                        ->select('COUNT(l)')
                        ->getQuery()
                        ->getSingleScalarResult();
        $nbrecette = $recetteRepo->getNb();
        $nbingredient = $ingredientRepo->getNb();
        $idrecetteofday =  $recetteRepo->getDayRecipe();
        $recette_de_la_journee = $recetteRepo->findOneById($idrecetteofday);
        
        return $this->render('MealSquareCommonBundle:Default:index.html.twig',array('nbrecette' => $nbrecette,
            'nbingredient' => $nbingredient,'nbuser' => $nbuser,'recette_de_la_journee' => $recette_de_la_journee));
    }

    public function contactAction() {
        return $this->render('MealSquareCommonBundle:Default:contact.html.twig');
    }

}
