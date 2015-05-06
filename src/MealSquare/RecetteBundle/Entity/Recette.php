<?php

namespace MealSquare\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Recette
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Recette
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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbPersonne", type="integer")
     */
    private $nbPersonne;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visibilite", type="boolean")
     */
    private $visibilite;

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulte", type="integer")
     */
    private $difficulte;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempsCuisson", type="integer")
     */
    private $tempsCuisson;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempsPreparation", type="integer")
     */
    private $tempsPreparation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="classique", type="boolean")
     */
    private $classique;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selection", type="boolean")
     */
    private $selection;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=30)
     */
    private $pays;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMAJ", type="datetime")
     */
    private $dateMAJ;

    /**
     * @var string
     *
     * @ORM\Column(name="saison", type="string", length=50)
     */
    private $saison;
    
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
    * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=false)
    */
    private $auteur;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="MealSquare\RecetteBundle\Entity\InfosBlock", mappedBy="Recette")
     *      
     */        
    private $recetteBlocks;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="MealSquare\RecetteBundle\Entity\IngredientRecette", mappedBy="Recette")
     *      
     */        
    private $ingredients;
    
    /** 
     *
     * @ORM\OneToOne(targetEntity="MealSquare\RecetteBundle\Entity\Note\RateThread", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $note;
    
    function __construct() {
        $this->dateCreation = new \DateTime();
        $this->dateMAJ = new \DateTime();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recetteBlocks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Creer les entités comment thread
     *
     * @return void 
     */
    public function createThread(){
        $this->note = new \MealSquare\RecetteBundle\Entity\Note\RateThread("recette".$this->id);
    
    }

    /**
     * @param MediaInterface $image
     */
    public function setImage(MediaInterface $media)
    {
        $this->image = $media;
    }

    /**
     * @return MediaInterface
     */
    public function getImage()
    {
        return $this->image;
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
     * Set titre
     *
     * @param string $titre
     * @return Recette
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
     * Set source
     *
     * @param string $source
     * @return Recette
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set nbPersonne
     *
     * @param integer $nbPersonne
     * @return Recette
     */
    public function setNbPersonne($nbPersonne)
    {
        $this->nbPersonne = $nbPersonne;

        return $this;
    }

    /**
     * Get nbPersonne
     *
     * @return integer 
     */
    public function getNbPersonne()
    {
        return $this->nbPersonne;
    }

    /**
     * Set visibilite
     *
     * @param boolean $visibilite
     * @return Recette
     */
    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    /**
     * Get visibilite
     *
     * @return boolean 
     */
    public function getVisibilite()
    {
        return $this->visibilite;
    }

    /**
     * Set difficulte
     *
     * @param integer $difficulte
     * @return Recette
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    /**
     * Get difficulte
     *
     * @return integer 
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }

    /**
     * Set tempsCuisson
     *
     * @param integer $tempsCuisson
     * @return Recette
     */
    public function setTempsCuisson($tempsCuisson)
    {
        $this->tempsCuisson = $tempsCuisson;

        return $this;
    }

    /**
     * Get tempsCuisson
     *
     * @return integer 
     */
    public function getTempsCuisson()
    {
        return $this->tempsCuisson;
    }

    /**
     * Set tempsPreparation
     *
     * @param integer $tempsPreparation
     * @return Recette
     */
    public function setTempsPreparation($tempsPreparation)
    {
        $this->tempsPreparation = $tempsPreparation;

        return $this;
    }

    /**
     * Get tempsPreparation
     *
     * @return integer 
     */
    public function getTempsPreparation()
    {
        return $this->tempsPreparation;
    }

    /**
     * Set classique
     *
     * @param boolean $classique
     * @return Recette
     */
    public function setClassique($classique)
    {
        $this->classique = $classique;

        return $this;
    }

    /**
     * Get classique
     *
     * @return boolean 
     */
    public function getClassique()
    {
        return $this->classique;
    }

    /**
     * Set selection
     *
     * @param boolean $selection
     * @return Recette
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;

        return $this;
    }

    /**
     * Get selection
     *
     * @return boolean 
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Recette
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set archive
     *
     * @param boolean $archive
     * @return Recette
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     * @return Recette
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateMAJ
     *
     * @param \DateTime $dateMAJ
     * @return Recette
     */
    public function setDateMAJ($dateMAJ)
    {
        $this->dateMAJ = $dateMAJ;

        return $this;
    }

    /**
     * Get dateMAJ
     *
     * @return \DateTime 
     */
    public function getDateMAJ()
    {
        return $this->dateMAJ;
    }

    /**
     * Set saison
     *
     * @param string $saison
     * @return Recette
     */
    public function setSaison($saison)
    {
        $this->saison = $saison;

        return $this;
    }

    /**
     * Get saison
     *
     * @return string 
     */
    public function getSaison()
    {
        return $this->saison;
    }

    /**
     * Set auteur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $auteur
     *
     * @return Recette
     */
    public function setAuteur(\Application\Sonata\UserBundle\Entity\User $auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Add tag
     *
     * @param \Application\Sonata\ClassificationBundle\Tag $tag
     *
     * @return Recette
     */
    public function addTag(\Application\Sonata\ClassificationBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \Application\Sonata\ClassificationBundle\Entity\Tag $tag
     */
    public function removeTag(\Application\Sonata\ClassificationBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set categorie
     *
     * @param \Sonata\ClassificationBundle\Model\CategoryInterface $categorie
     *
     * @return Recette
     */
    public function setCategorie(\Sonata\ClassificationBundle\Model\CategoryInterface $categorie = null)
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
     * Set note
     *
     * @param \MealSquare\RecetteBundle\Entity\Note\RateThread $note
     *
     * @return Recette
     */
    public function setNote(\MealSquare\RecetteBundle\Entity\Note\RateThread $note = null)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return \MealSquare\RecetteBundle\Entity\Note\RateThread
     */
    public function getNote()
    {
        return $this->note;
    }

    

    /**
     * Add recetteBlock
     *
     * @param \MealSquare\RecetteBundle\Entity\InfosBlock $recetteBlock
     *
     * @return Recette
     */
    public function addRecetteBlock(\MealSquare\RecetteBundle\Entity\InfosBlock $recetteBlock)
    {
        $this->recetteBlocks[] = $recetteBlock;

        return $this;
    }

    /**
     * Remove recetteBlock
     *
     * @param \MealSquare\RecetteBundle\Entity\InfosBlock $recetteBlock
     */
    public function removeRecetteBlock(\MealSquare\RecetteBundle\Entity\InfosBlock $recetteBlock)
    {
        $this->recetteBlocks->removeElement($recetteBlock);
    }

    /**
     * Get recetteBlocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecetteBlocks()
    {
        return $this->recetteBlocks;
    }
    
    public function __toString() {
        return $this->titre;
    }


    /**
     * Add ingredient
     *
     * @param \MealSquare\RecetteBundle\Entity\IngredientRecette $ingredient
     *
     * @return Recette
     */
    public function addIngredient(\MealSquare\RecetteBundle\Entity\IngredientRecette $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \MealSquare\RecetteBundle\Entity\IngredientRecette $ingredient
     */
    public function removeIngredient(\MealSquare\RecetteBundle\Entity\IngredientRecette $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
