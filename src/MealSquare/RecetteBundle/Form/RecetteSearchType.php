<?php
namespace MealSquare\RecetteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormBuilder;
use Doctrine\ORM\EntityRepository;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecetteSearchType
 *
 * @author LE MOPORG
 */
class RecetteSearchType extends AbstractType{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
   {
       $builder
            ->add('titre', 'text',array('required' => false))
            ->add('difficulte', 'choice', array(
                'choices'   => array(
                                    '0' => 'Très facile',
                                    '1' => 'Facile',
                                    '2' => 'Moyen',
                                    '3' => 'Difficile',
                                    '4' => 'Délicat'
                    
                                ),
                'required'  => False,
                'empty_value' => 'Difficulté',
            ))
            ->add('specialite', 'choice', array(
                'choices'   => array('0' => 'Saint-Valentin' , '1' => 'Enfants et ados' , '2' => 'Recettes anglo-saxonne' , '3' => 'Française' , '4' => 'Chic et facile' , '5' => 'Recettes méditerranéennes' , '6' => 'Cuisine brésilienne' , '7' => 'Spécialités antillaises' , '8' => 'Recettes italiennes' , '9' => 'Exotique' , '10' => 'Suisse' , '11' => 'Recettes de Chef' , '12' => 'Inde' , '13' => 'Pâques' , '14' => 'Provence' , '15' => 'Cuisine marocaine' , '16' => 'Orientale' , '17' => 'Repas de fête' , '18' => 'Cuisine légère' , '19' => 'Cuisine rapide' , '20' => 'Mardi Gras' , '21' => 'Asie' , '22' => 'Nordique' , '23' => 'Bretagne' , '24' => 'Recettes végétariennes' , '25' => 'Recettes japonaises' , '26' => 'Sud-ouest' , '27' => 'Spécialités ibériques' , '28' => 'Normandie' , '29' => 'Recettes chinoises' , '30' => 'Thanksgiving' , '31' => 'Auvergne' , '32' => 'Halloween' , '33' => 'Recettes américaines' , '24' => 'Pentecôte'),
                'required'  => False,
                'empty_value' => 'Spécialité',
            )) 
            ->add('categorie', 'entity', array(
                'class' => 'Application\Sonata\ClassificationBundle\Entity\Category',
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('c')
                              ->join('c.context','co')
                              ->where('co.name  = :context')
                              ->setParameter('context', 'recette')
                              ->orderBy('c.name', 'ASC');
                }))
        ;
   }
   
    public function getName() {
        return 'recette_search_type';
    }

//put your code here
}
