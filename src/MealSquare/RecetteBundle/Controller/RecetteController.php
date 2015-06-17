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
        $repository     = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Recette");
        $likeRepository = $this->getDoctrine()->getRepository('MealSquareRecetteBundle:Like\Like');
        $rateRepository = $this->getDoctrine()->getRepository('MealSquareRecetteBundle:Note\Rate');
        $recette        = $repository->findOneById($id);
        $user           = $this->get('security.context')->getToken()->getUser();
        
        if(is_null($recette)){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            
            $likers     = $likeRepository->findBy(
                                                array('thread' => $recette->getLike()),
                                                array('id' => 'desc'),
                                                9,
                                                0
                        );
            // On vérifie si le user a déjà liker la recette
            $isLiker    = (!is_null($likeRepository->findOneBy(array('thread' => $recette->getLike(), 'liker'=>  $user))))?true:false;
            // On vérifie si le user a déjà cette recette en favoris
            $isFavoris  = ($user instanceof \Application\Sonata\UserBundle\Entity\User && $user->getRecettesFavoris()->contains($recette));
            // On vérifie si le user a déjà noter la recette
            $isRater    = (!is_null($rateRepository->findOneBy(array('thread' => $recette->getLike(), 'rater'=>  $user))))?true:false;
            
            return $this->render('MealSquareRecetteBundle:Recette:show.html.twig', array(
                'recette' => $recette,
                'isLiker'=>$isLiker,
                'likers'=>$likers,
                'isFavoris'=>$isFavoris,
                'isRater'=>$isRater
            ));
        }
        
    }
    
    public function printAction($id) {
        $repository     = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Recette");
        $recette        = $repository->findOneById($id);
        
        if(is_null($recette)){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            
            return $this->render('MealSquareRecetteBundle:Recette:print.html.twig', array(
                'recette' => $recette
            ));
        }
        
    }
    
    public function deleteFavorisAction($id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        $user= $this->get('security.context')->getToken()->getUser();
        $user->removeRecettesFavori($recette);
        
        $em->persist($user);
        $em->flush();

        return $this->redirect( $this->generateUrl('fos_user_profile_show') );
    }
    
    public function addFavorisAction($id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        $user= $this->get('security.context')->getToken()->getUser();
        $user->addRecettesFavori($recette);
        
        $em->persist($user);
        $em->flush();

        return $this->redirect( $this->generateUrl( 'meal_square_recette_show', array('id' => $recette->getId()) ));
    }
    
    public function deleteAction($id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        $user= $this->get('security.context')->getToken()->getUser();
        
        if(is_null($recette) || $user->getId()!==$recette->getAuteur()->getId()){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            
            $em->remove($recette);
            $em->flush();

            return $this->redirect( $this->generateUrl('fos_user_profile_show') );
        }
        
        
        
    }
    
    public function editAction($id) {
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $usr= $this->get('security.context')->getToken()->getUser();

        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        if(is_null($recette) || $usr->getId() !== $recette->getAuteur()->getId()){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            
            $form = $this->createForm(new RecetteEditType(), $recette);

            $form->handleRequest($this->getRequest());

            if ($form->isValid()) {
                $recette = $form->getData();

                // On recupere la saison, la difficulté et la specialité
                $recette->setDifficulte($this->manageAttribut('difficulte',$recette->getDifficulte()));
                $recette->setSaison($this->manageAttribut('saison',$recette->getSaison()));
                $recette->setSpecialite($this->manageAttribut('specialite',$recette->getSpecialite()));
            
                $em->persist($recette);
                $em->flush();  

                if(!$recette->getArchive())
                    return $this->redirect( $this->generateUrl( 'meal_square_recette_show', array('id' => $recette->getId()) ));
                else
                    return $this->redirect( $this->generateUrl('fos_user_profile_show'));
            }

            return $this->render('MealSquareRecetteBundle:Recette:add.html.twig', array('form' => $form->createView(), 'edit' => true));

            
        }


        
    }
    
    public function addAction() {
        
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new RecetteType(), new Recette());

        $form->handleRequest($this->getRequest());
        
        
        if ($form->isValid()) {
            $recette = $form->getData();
            // On recupere la saison, la difficulté et la specialité
            $recette->setDifficulte($this->manageAttribut('difficulte',$recette->getDifficulte()));
            $recette->setSaison($this->manageAttribut('saison',$recette->getSaison()));
            $recette->setSpecialite($this->manageAttribut('specialite',$recette->getSpecialite()));
            // On recupere le current user
            $usr     = $this->get('security.context')->getToken()->getUser();
            $recette->setAuteur($usr);
            
            $em->persist($recette);
            $em->flush();  
            
            $recette->createThread();
            
            $em->persist($recette);
            $em->flush();

            
            if(!$recette->getArchive())
                return $this->redirect( $this->generateUrl( 'meal_square_recette_show', array('id' => $recette->getId()) ));
            else
                return $this->redirect( $this->generateUrl('fos_user_profile_show'));

        }

        return $this->render('MealSquareRecetteBundle:Recette:add.html.twig', array('form' => $form->createView()));
    }
    
    public function manageAttribut  ($type, $position ){
        $tabs = array();
        $tabs['difficulte'] = array(
                                '0' => 'Très facile',
                                '1' => 'Facile',
                                '2' => 'Moyen',
                                '3' => 'Difficile',
                                '4' => 'Délicat'
                    
                        );
        $tabs['saison'] = array(
                            '0' => 'Été',
                            '1' => 'Printemps',
                            '2' => 'Automne',
                            '3' => 'Hiver'

                        );
        
        $tabs['specialite'] = array('0' => 'Saint-Valentin' , '1' => 'Enfants et ados' , '2' => 'Recettes anglo-saxonne' , '3' => 'Française' , '4' => 'Chic et facile' , '5' => 'Recettes méditerranéennes' , '6' => 'Cuisine brésilienne' , '7' => 'Spécialités antillaises' , '8' => 'Recettes italiennes' , '9' => 'Exotique' , '10' => 'Suisse' , '11' => 'Recettes de Chef' , '12' => 'Inde' , '13' => 'Pâques' , '14' => 'Provence' , '15' => 'Cuisine marocaine' , '16' => 'Orientale' , '17' => 'Repas de fête' , '18' => 'Cuisine légère' , '19' => 'Cuisine rapide' , '20' => 'Mardi Gras' , '21' => 'Asie' , '22' => 'Nordique' , '23' => 'Bretagne' , '24' => 'Recettes végétariennes' , '25' => 'Recettes japonaises' , '26' => 'Sud-ouest' , '27' => 'Spécialités ibériques' , '28' => 'Normandie' , '29' => 'Recettes chinoises' , '30' => 'Thanksgiving' , '31' => 'Auvergne' , '32' => 'Halloween' , '33' => 'Recettes américaines' , '24' => 'Pentecôte');

        $tab = $tabs[$type];
        
        return (isset($tab[$position]))? $tab[$position]: $position;
    }
    
    public function cloneAction($id) {
        
        $em         = $this->getDoctrine()->getEntityManager();
        $usr        = $this->get('security.context')->getToken()->getUser();
        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette    = $repository->findOneById($id);
        
        if(is_null($recette)){
                throw new NotFoundHttpException("Désolé, la page que vous avez demandée semble introuvable !");
        }else{
            
            $isVersion  = (!is_null($recette->getAuteur()) && $usr->getId() == $recette->getAuteur()->getId());
            $clone      = $recette->copy();
            
            $form = $this->createForm(new RecetteEditType(), $clone);

            $form->handleRequest($this->getRequest());
            

            if ($form->isValid()) {
                $clone = $form->getData();

                // On recupere la saison, la difficulté et la specialité
                $clone->setDifficulte($this->manageAttribut('difficulte',$clone->getDifficulte()));
                $clone->setSaison($this->manageAttribut('saison',$clone->getSaison()));
                $clone->setSpecialite($this->manageAttribut('specialite',$clone->getSpecialite()));
                $clone->setAuteur($usr);
                
                $em     ->persist($clone);
                $em     ->flush(); 
                
                if($isVersion)
                    $recette->addVersion($clone);
                else
                    $recette->addVariante($clone);
                
                $clone->createThread();
                $em     ->persist($recette);
                $em     ->persist($clone);
                $em     ->flush();  
                
                if(!$clone->getArchive())
                    return $this->redirect( $this->generateUrl( 'meal_square_recette_show', array('id' => $clone->getId()) ));
                else
                    return $this->redirect( $this->generateUrl('fos_user_profile_show'));

            }

            return $this->render('MealSquareRecetteBundle:Recette:add.html.twig', array('form' => $form->createView(),'isVersion'=>$isVersion));

            
        }


        
    }

}
