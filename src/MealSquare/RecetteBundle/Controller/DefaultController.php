<?php

namespace MealSquare\RecetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MealSquareRecetteBundle:Default:index.html.twig', array('name' => $name));
    }
}
