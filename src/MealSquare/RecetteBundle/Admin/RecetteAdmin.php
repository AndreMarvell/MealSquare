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
            ->tab('Informations Générales')
                ->with('Information', array(
                        'class' => 'col-md-8'
                    ))
                    ->add('auteur', 'sonata_type_model_list')
                    ->add('titre')
                    ->add('source')
                    ->add('nbPersonne')
                    ->add('saison')
                    ->add('specialite')
                    ->add('pays')
                    ->add('image', 'sonata_type_model_list', array('required' => false), array(
                        'link_parameters' => array(
                            'context' => 'recette',
                            'hide_context' => true
                        )
                    ))

                    ->add('categorie', 'sonata_type_model_list', array('required' => false), array(
                        'link_parameters' => array(
                            'context' => 'recette',
                            'hide_context' => true
                        )
                    ))
                    ->add('tags', 'sonata_type_model_autocomplete', array(
                        'property' => 'name',
                        'multiple' => 'true'
                    ))
                ->end()
                ->with('Stats', array(
                        'class' => 'col-md-4'
                    ))
                    ->add('visibilite') 
                    ->add('classique')
                    ->add('selection')
                    ->add('archive')
                    ->add('recetteDuJour') 
                    ->add('recetteDuMois') 
                    ->add('recetteDeLaSemaine')  
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
            ->end()
            ->tab('Etapes Recette')
                ->with('Recette')    
                    ->add('recetteBlocks', 'sonata_type_collection', array(), array(
                             'edit' => 'inline',
                             'sortable'  => 'position'

                    ))
                ->end()
            ->end()
            ->tab('Versionning')
                ->with('Variante')    
                    ->add('recetteMere')
                ->end()
                ->with('Variante')    
                    ->add('variantes')
                ->end()
                ->with('Versions')    
                    ->add('versions')
                ->end()
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