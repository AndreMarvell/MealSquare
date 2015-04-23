<?php

namespace MealSquare\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MealSquareCommonBundle:Default:index.html.twig');
    }
}
