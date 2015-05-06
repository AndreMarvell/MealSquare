<?php

namespace MealSquare\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IngredientRecette
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IngredientRecette
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="quantite", type="string", length=255)
     */
    private $quantite;
    
    /**
     * @var \MealSquare\RecetteBundle\Entity\Ingredient
     * @ORM\ManyToOne(targetEntity="MealSquare\RecetteBundle\Entity\Ingredient", cascade={"persist"}, fetch="LAZY")
     */
    protected $ingredient;
    
    /**
     * @ORM\ManyToOne(targetEntity="Recette", inversedBy="IngredientRecette")
     * @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     */
    protected $recette;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantite
     *
     * @param string $quantite
     *
     * @return IngredientRecette
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return string
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set ingredient
     *
     * @param \MealSquare\RecetteBundle\Entity\Ingredient $ingredient
     *
     * @return IngredientRecette
     */
    public function setIngredient(\MealSquare\RecetteBundle\Entity\Ingredient $ingredient = null)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \MealSquare\RecetteBundle\Entity\Ingredient
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set recette
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $recette
     *
     * @return IngredientRecette
     */
    public function setRecette(\MealSquare\RecetteBundle\Entity\Recette $recette = null)
    {
        $this->recette = $recette;

        return $this;
    }

    /**
     * Get recette
     *
     * @return \MealSquare\RecetteBundle\Entity\Recette
     */
    public function getRecette()
    {
        return $this->recette;
    }
}
