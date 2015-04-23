<?php

namespace MealSquare\RecetteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RecetteAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Information', array(
                    'class' => 'col-md-8'
                ))
                ->add('auteur')
                ->add('titre')
                ->add('source')
                ->add('nbPersonne')
                ->add('saison')
                ->add('pays')
                ->add('image', 'sonata_type_model_list', array('required' => false), array(
                    'link_parameters' => array(
                        'context' => 'recette',
                        'hide_context' => true
                    )
                ))
            ->end()
            ->with('Stats', array(
                    'class' => 'col-md-4'
                ))
                ->add('visibilite') 
                ->add('classique')
                ->add('selection')
                ->add('archive') 
                ->add('difficulte') 
                ->add('tempsCuisson') 
                ->add('tempsPreparation')
            ->end()
            ->with('Autres', array(
                    'class' => 'col-md-4'
                ))
                ->add('dateCreation', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
                ->add('dateMAJ', 'sonata_type_datetime_picker', array('dp_side_by_side' => true))
            
            ->end()
                   
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('auteur')
            ->add('titre')
            ->add('archive')
            ->add('dateCreation')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('custom', 'string', array('template' => 'MealSquareCommonBundle:Admin:list_imagefield_custom.html.twig', 'label' => 'Image'))
            ->add('auteur')
            ->addIdentifier('titre')
            ->add('archive')
            ->add('visibilite')
            ->add('dateCreation')
        ;
    }
}    