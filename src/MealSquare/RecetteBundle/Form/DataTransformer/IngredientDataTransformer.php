<?php

namespace MealSquare\RecetteBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class IngredientDataTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    private $entityClass;
    private $entityType;
    private $entityRepository;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->setEntityClass("MealSquare\RecetteBundle\Entity\Ingredient");
        $this->setEntityRepository("MealSquareRecetteBundle:Ingredient");
        $this->setEntityType("Ingredient");
    }

    /**
     * Transforms an object  to a string .
     *
     * @param  Ingredient|null $ingredient
     * @return string
     */
    public function transform($ingredient)
    {
        if (null === $ingredient) {
            return "";
        }

        return $ingredient->getLibelle();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string name
     *
     * @return Product|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }
        
        $ingredient = $this->om->getRepository($this->entityRepository)->findOneByLibelle($name);

        if (null === $name) {
            throw new TransformationFailedException(sprintf(
                'Le récupération de l\'ingrédient %s a échoué',
                $name
            ));
        }

        return $ingredient;
    }
    
    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;
    }
 
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }
 
    public function setEntityRepository($entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }
    
}