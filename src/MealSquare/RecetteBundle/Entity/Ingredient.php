<?php

namespace MealSquare\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredient
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="MealSquare\RecetteBundle\Entity\Repository\IngredientRepository")
 */
class Ingredient
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
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    
    /**
     * @var \Application\Sonata\MediaBundle\Entity\Media
     * @ORM\ManyToOne(targetEntity="Application\Sonata\MediaBundle\Entity\Media", cascade={"persist"}, fetch="LAZY")
     */
    protected $image;
    
    /**
     * @var \Application\Sonata\ClassificationBundle\Entity\Category
     * @ORM\ManyToOne(targetEntity="Application\Sonata\ClassificationBundle\Entity\Category", cascade={"persist"}, fetch="LAZY")
     */
    protected $categorie;
    
    /**
     * @ORM\OneToOne(targetEntity="\Application\Sonata\MediaBundle\Entity\Gallery", cascade={"all"})
     */
    private $galerie;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Ingredient
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Ingredient
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     *
     * @return Ingredient
     */
    public function setImage(\Application\Sonata\MediaBundle\Entity\Media $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Application\Sonata\MediaBundle\Entity\Media
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set categorie
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Category $categorie
     *
     * @return Ingredient
     */
    public function setCategorie(\Application\Sonata\ClassificationBundle\Entity\Category $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Application\Sonata\ClassificationBundle\Entity\Category
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set galerie
     *
     * @param \Application\Sonata\MediaBundle\Entity\Gallery $galerie
     *
     * @return Ingredient
     */
    public function setGalerie(\Application\Sonata\MediaBundle\Entity\Gallery $galerie = null)
    {
        $this->galerie = $galerie;

        return $this;
    }

    /**
     * Get galerie
     *
     * @return \Application\Sonata\MediaBundle\Entity\Gallery
     */
    public function getGalerie()
    {
        return $this->galerie;
    }
    
    public function __toString() {
        return $this->libelle;
    }

}
