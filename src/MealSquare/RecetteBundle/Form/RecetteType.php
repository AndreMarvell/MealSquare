<?php

namespace MealSquare\RecetteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RecetteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('source')
            ->add('specialite', 'choice', array(
                'choices'   => array('0' => 'Saint-Valentin' , '1' => 'Enfants et ados' , '2' => 'Recettes anglo-saxonne' , '3' => 'Française' , '4' => 'Chic et facile' , '5' => 'Recettes méditerranéennes' , '6' => 'Cuisine brésilienne' , '7' => 'Spécialités antillaises' , '8' => 'Recettes italiennes' , '9' => 'Exotique' , '10' => 'Suisse' , '11' => 'Recettes de Chef' , '12' => 'Inde' , '13' => 'Pâques' , '14' => 'Provence' , '15' => 'Cuisine marocaine' , '16' => 'Orientale' , '17' => 'Repas de fête' , '18' => 'Cuisine légère' , '19' => 'Cuisine rapide' , '20' => 'Mardi Gras' , '21' => 'Asie' , '22' => 'Nordique' , '23' => 'Bretagne' , '24' => 'Recettes végétariennes' , '25' => 'Recettes japonaises' , '26' => 'Sud-ouest' , '27' => 'Spécialités ibériques' , '28' => 'Normandie' , '29' => 'Recettes chinoises' , '30' => 'Thanksgiving' , '31' => 'Auvergne' , '32' => 'Halloween' , '33' => 'Recettes américaines' , '24' => 'Pentecôte'),
                'required'  => true,
                'empty_value' => 'Spécialité',
            ))
            ->add('nbPersonne')
            ->add('description')
            ->add('visibilite', 'checkbox', array(
                    'required'=>false
                ))
            ->add('difficulte', 'choice', array(
                'choices'   => array(
                                    '0' => 'Très facile',
                                    '1' => 'Facile',
                                    '2' => 'Moyen',
                                    '3' => 'Difficile',
                                    '4' => 'Délicat'
                    
                                ),
                'required'  => true,
                'empty_value' => 'Niveau de difficulté?',
            ))
            ->add('tempsCuisson')
            ->add('tempsPreparation')
            ->add('recetteBlocks', 'collection', array(
                'type' => new InfosBlockType(),
                'prototype' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
            ->add('ingredients', 'collection', array(
                    'type' => 'ingredient_recette_type',
                    'prototype' => true,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
            ))
            ->add('pays',"genemu_jqueryselect2_country", array(
                'empty_value' => 'Pays' 
            ))
            ->add('saison', 'choice', array(
                'choices'   => array(
                                    '0' => 'Été',
                                    '1' => 'Printemps',
                                    '2' => 'Automne',
                                    '3' => 'Hiver'
                    
                                ),
                'required'  => true,
                'empty_value' => 'Saison idéale',
            ))
            ->add('image', 'sonata_media_type', array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'recette',
                    'required'=>true
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
            //->add('tags')
        ;
        $builder->get('image')->add('contentType', 'hidden');
        $builder->get('image')->add('unlink', 'hidden', ['mapped' => false, 'data' => false]);
        $builder->get('image')->add('binaryContent', 'file', ['label' => false]);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MealSquare\RecetteBundle\Entity\Recette'
        ));
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'recette_type';
    }
}
