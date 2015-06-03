<?php


namespace MealSquare\RecetteBundle\Command;
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Application\Sonata\MediaBundle\Entity\Media;
use MealSquare\CommonBundle\Entity\acurl;
use MealSquare\RecetteBundle\Entity\Recette;

/**
 * Description of ImportAeroportCommand
 *
 * @author ikounga_marvel
 */
class ImportRecetteUpdateCommand extends ContainerAwareCommand{
    
    private $recette_repository;
    private $em ;


    protected function configure()
    {
        $this
            ->setName('recettes:update')
            ->setDescription('Mise à jour des recettes en BDD')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        
        $this->em = $this->getContainer()->get('doctrine')->getManager();
        $this->recette_repository = $this->em->getRepository('MealSquareRecetteBundle:Recette');
        $recettes = $this->recette_repository->findAll();
        
        foreach ($recettes as $recette){
            
            if(is_null($recette->getLike())){
                
               $recette->setLike(new \MealSquare\RecetteBundle\Entity\Like\LikeThread("recette".$recette->getId())); 
               $this->em->persist($recette);
               $this->em->flush(); 
               echo PHP_EOL.'Mise à jour du Like de la recette "'.$recette->getTitre().'" réalisé avec succès'.PHP_EOL;
            
               
            }else{
               echo PHP_EOL.'LikeThread de la recette "'.$recette->getTitre().'" déja à jour'.PHP_EOL; 
            }
            
            if (is_null($recette->getNote())) {
                
               $recette->setNote(new \MealSquare\RecetteBundle\Entity\Note\NoteThread("recette".$recette->getId())); 
               $this->em->persist($recette);
               $this->em->flush(); 
               echo PHP_EOL.'Mise à jour de la note de la recette "'.$recette->getTitre().'" réalisé avec succès'.PHP_EOL;
            
               
            }else{
               echo PHP_EOL.'NoteThread de la recette "'.$recette->getTitre().'" déja à jour'.PHP_EOL; 
            }
            
            
        }
    }

}

