<?php

namespace MealSquare\RecetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MealSquareRecetteBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function loginAction()
    {
        return $this->render('ApplicationSonataUserBundle:Security:login.html.twig');
    }
    
    public function registerAction()
    {
        return $this->render('ApplicationSonataUserBundle:Registration:register.html.twig');
    }
}
