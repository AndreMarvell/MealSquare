<?php

namespace MealSquare\RecetteBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RaccourciAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nom')
            ->add('type')
            ->add('icone')
            ->add('actif')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nom')
            ->add('type')
            ->add('icone')
            ->add('actif')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nom')
            ->add('slug')
            ->add('type', 'choice', array(
                'choices'   => array(
                    'ingredient' => 'Ingrédient' ,
                    'categorie' => 'Catégorie' ,
                    'pays' => 'Pays' ,
                    'specialite' => 'Spécialité'), 
                'required'  => true,
                'empty_value' => 'Type de raccourci',
            ))
            ->add('icone')
            ->add('description')
            ->add('actif')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('nom')
            ->add('type')
            ->add('icone')
            ->add('actif')
        ;
    }
}
