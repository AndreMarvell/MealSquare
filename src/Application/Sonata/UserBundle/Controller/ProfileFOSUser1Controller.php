<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\Model\UserInterface;
use Sonata\UserBundle\Controller\ProfileFOSUser1Controller as BaseController;
use Application\Sonata\UserBundle\Form\AvatarType;

/**
 * This class is inspired from the FOS Profile Controller, except :
 *   - only twig is supported
 *   - separation of the user authentication form with the profile form
 */
class ProfileFOSUser1Controller extends BaseController
{
    /**
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        
        $repository = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Recette");
        $recettes = $repository->findByAuteur($user);

        return $this->render('SonataUserBundle:Profile:show.html.twig', array(
            'user'   => $user,
            'recettes' => $recettes,
            'blocks' => $this->container->getParameter('sonata.user.configuration.profile_blocks')
        ));
    }
    
    /**
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function avatarAction(){
        $em = $this->getDoctrine()->getEntityManager();
        $user= $this->get('security.context')->getToken()->getUser();
        
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }else{
            $form = $this->createForm(new AvatarType(), $user);

            $form->handleRequest($this->getRequest());

            if ($form->isValid()) {
                $user = $form->getData();
                $em->persist($user);
                $em->flush();  
                
                return $this->redirect( $this->generateUrl('fos_user_profile_show'));
            }

            return $this->render('ApplicationSonataUserBundle:Profile:avatar.html.twig', array('form' => $form->createView()));

        }
        
        
        
    }
    
    /**
     * @return Response
     *
     * @throws AccessDeniedException
     */
    public function otherAction($id)
    {
        $userRepository     = $this->getDoctrine()->getRepository("ApplicationSonataUserBundle:User");
        $member             = $userRepository->find($id);
        
        if(is_null($member)){
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException("Profil not found");
        }else{
            
            $recetteRepository  = $this->getDoctrine()->getRepository("MealSquareRecetteBundle:Recette");
            $recettes           = $recetteRepository->findBy(array(
                                'auteur' =>$member,
                                'visibilite'=>true,
                                'archive'=>false
                            ));

            return $this->render('SonataUserBundle:Profile:show_other.html.twig', array(
                'membre'   => $member,
                'recettes' => $recettes,
                'blocks' => $this->container->getParameter('sonata.user.configuration.profile_blocks')
            ));
        }
    }


//    /**
//     * @return Response
//     *
//     * @throws AccessDeniedException
//     */
//    public function editProfileAction()
//    {
//        $user = $this->container->get('security.context')->getToken()->getUser();
//        if (!is_object($user) || !$user instanceof UserInterface) {
//            throw new AccessDeniedException('This user does not have access to this section.');
//        }
//
//        $form = $this->container->get('sonata.user.profile.form');
//        $formHandler = $this->container->get('sonata.user.profile.form.handler');
//
//        $process = $formHandler->process($user);
//        if ($process) {
//            $this->setFlash('sonata_user_success', 'profile.flash.updated');
//
//            return new RedirectResponse($this->generateUrl('sonata_user_profile_show'));
//        }
//
//        return $this->render('SonataUserBundle:Profile:edit_profile.html.twig', array(
//            'form'               => $form->createView(),
//            'breadcrumb_context' => 'user_profile',
//        ));
//    }

}