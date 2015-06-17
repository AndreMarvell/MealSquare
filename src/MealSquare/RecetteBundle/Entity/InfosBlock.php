<?php

namespace MealSquare\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InfosBlock
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class InfosBlock
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
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $titre;

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
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $lien;
    
    /**
     * @ORM\ManyToOne(targetEntity="Recette", inversedBy="infosBlock")
     * @ORM\JoinColumn(name="recette_id", referencedColumnName="id")
     */
    protected $recette;
    
    
    public function copy() {
        $clone = new InfosBlock();
        
        $clone->setTitre($this->titre);
        $clone->setDescription($this->description);
        $clone->setImage($this->image);
        $clone->setLien($this->lien);
        
        return $clone;
    }

    
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
     * Set description
     *
     * @param string $description
     *
     * @return InfosBlock
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
     * Set titre
     *
     * @param string $titre
     *
     * @return InfosBlock
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return InfosBlock
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set image
     *
     * @param \Application\Sonata\MediaBundle\Entity\Media $image
     *
     * @return InfosBlock
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
     * Set recette
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $recette
     *
     * @return InfosBlock
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
    
    public function __toString() {
        if(is_null($this->titre))
            return substr($this->description, 0, 20);
        else 
            return $this->titre;
    }
}
