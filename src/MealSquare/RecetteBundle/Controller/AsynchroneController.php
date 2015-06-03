<?php

namespace MealSquare\RecetteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MealSquare\RecetteBundle\Entity\Like\Like;

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
    
    public function likeAction()
    {
        
        $request    = $this->get('request');
        $em         = $this->getDoctrine()->getEntityManager();
        $thread     = $request->request->get('id');
        $user       = $this->get('security.context')->getToken()->getUser();
        $like       = $em->getRepository('MealSquareRecetteBundle:Like\Like')->findOneBy(array(
                        'thread' => $thread,
                        'liker'  => $user
                    ));
        
        if(is_null($like)){
            $like = new Like($em->getRepository('MealSquareRecetteBundle:Like\LikeThread')->find($thread),$user);
            $em->persist($like);
            $em->flush($like);
        }
        else{
            $em->remove($like);
            $em->flush($like);
        }
        
        $thread = $like->getThread();
        $em->flush($thread);
        
        $response = new Response();
        $response->setContent(json_encode(array("success"=>true)));
        $response -> headers -> set('Content-Type', 'application/json');
        
        return $response;
    }
    
    public function favorisAction()
    {
        
        $request    = $this->get('request');
        $em         = $this->getDoctrine()->getEntityManager();
        $id         = $request->request->get('id');

        $repository = $em->getRepository("MealSquareRecetteBundle:Recette");
        $recette = $repository->findOneById($id);
        
        if(is_null($recette)){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Cette recette n'existe pas");
        }else{
            $user= $this->get('security.context')->getToken()->getUser();

            if($user->getRecettesFavoris()->contains($recette)){
                $user->removeRecettesFavori($recette);
            }else{
                $user->addRecettesFavori($recette);
            }

            $em->persist($user);
            $em->flush();
            
            $response = new Response();
            $response->setContent(json_encode(array("success"=>true)));
            $response -> headers -> set('Content-Type', 'application/json');
            return $response;

            
        }
    }
}
