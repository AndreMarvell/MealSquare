<?php

namespace MealSquare\RecetteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\MediaBundle\Model\MediaInterface;

/**
 * Recette
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="MealSquare\RecetteBundle\Entity\Repository\RecetteRepository")
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
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255)
     */
    private $specialite;

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
    private $visibilite = false;

    /**
     * @var integer
     *
     * @ORM\Column(name="difficulte", type="string", length=25)
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
    private $classique  = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="selection", type="boolean")
     */
    private $selection  = false;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=30, nullable=true)
     */
    private $pays;

    /**
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean")
     */
    private $archive  = false;

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
     * @ORM\Column(name="saison", type="string", length=50, nullable=true)
     */
    private $saison;
    
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
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
    * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=true)
    */
    private $auteur;
    
    /**
     * @ORM\ManyToMany(targetEntity="Application\Sonata\ClassificationBundle\Entity\Tag", cascade={"persist"})
     */
    private $tags;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="MealSquare\RecetteBundle\Entity\InfosBlock", mappedBy="recette", cascade={"remove","persist"})
     *      
     */        
    private $recetteBlocks;
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\OneToMany(targetEntity="MealSquare\RecetteBundle\Entity\IngredientRecette", mappedBy="recette", cascade={"remove","persist"})
     *      
     */        
    private $ingredients;
    
     /**
     * @var string
     *
     * @ORM\Column(name="full_ingredients", type="text", nullable=true)
     */
    private $full_ingredients;
    
    /** 
     *
     * @ORM\OneToOne(targetEntity="MealSquare\RecetteBundle\Entity\Note\RateThread", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $note;
    
    /** 
     *
     * @ORM\OneToOne(targetEntity="MealSquare\RecetteBundle\Entity\Like\LikeThread", cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $like;
    
    /**
     * @ORM\ManyToOne(targetEntity="Recette")
     * @ORM\JoinColumn(nullable=true)
     */
    private $recetteMere;

    /**
     * @ORM\ManyToMany(targetEntity="Recette", inversedBy="recetteMere")
     * @ORM\JoinTable(name="variantes",
     *      joinColumns={@ORM\JoinColumn(name="recette_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="variante_recette_id", referencedColumnName="id")}
     *      )
     */
    private $variantes;
    
    /**
     * @ORM\ManyToMany(targetEntity="Recette", inversedBy="recetteMere")
     * @ORM\JoinTable(name="versions",
     *      joinColumns={@ORM\JoinColumn(name="recette_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="version_recette_id", referencedColumnName="id")}
     *      )
     */
    private $versions;
    
    function __construct() {
        $this->dateCreation = new \DateTime();
        $this->dateMAJ = new \DateTime();
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->recetteBlocks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
        $this->variantes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->versions = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Creer les entités comment thread
     *
     * @return void 
     */
    public function createThread(){
        $this->note = new \MealSquare\RecetteBundle\Entity\Note\RateThread("recette".$this->id);
        $this->like = new \MealSquare\RecetteBundle\Entity\Like\LikeThread("recette".$this->id);
    
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
        $recetteBlock->setRecette($this);

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
        $ingredient->setRecette($this);

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

    /**
     * Set fullIngredients
     *
     * @param string $fullIngredients
     *
     * @return Recette
     */
    public function setFullIngredients($fullIngredients)
    {
        $this->full_ingredients = $fullIngredients;

        return $this;
    }

    /**
     * Get fullIngredients
     *
     * @return string
     */
    public function getFullIngredients()
    {
        return $this->full_ingredients;
    }
    
    public function isIngredientsFormatted(){
        if (is_null($this->full_ingredients))
            return true;
        else
            return false;
    }

    /**
     * Set specialite
     *
     * @param string $specialite
     *
     * @return Recette
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;

        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Recette
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
     * Set recetteMere
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $recetteMere
     *
     * @return Recette
     */
    public function setRecetteMere(\MealSquare\RecetteBundle\Entity\Recette $recetteMere = null)
    {
        $this->recetteMere = $recetteMere;

        return $this;
    }

    /**
     * Get recetteMere
     *
     * @return \MealSquare\RecetteBundle\Entity\Recette
     */
    public function getRecetteMere()
    {
        return $this->recetteMere;
    }

    /**
     * Add variante
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $variante
     *
     * @return Recette
     */
    public function addVariante(\MealSquare\RecetteBundle\Entity\Recette $variante)
    {
        if (!$this->variantes->contains($variante)) {
            $variante->setRecetteMere($this);
            $this->variantes[] = $variante;
        }
        

        return $this;
    }

    /**
     * Remove variante
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $variante
     */
    public function removeVariante(\MealSquare\RecetteBundle\Entity\Recette $variante)
    {
        if ($this->variantes->contains($variante)) {
            $variante->setRecetteMere(null);
            $this->variantes->removeElement($variante);
        }
        
    }

    /**
     * Get variantes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariantes()
    {
        return $this->variantes;
    }

    /**
     * Add version
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $version
     *
     * @return Recette
     */
    public function addVersion(\MealSquare\RecetteBundle\Entity\Recette $version)
    {
        if (!$this->versions->contains($version)) {
            $version->setRecetteMere($this);
            $this->versions[] = $version;
        }

        return $this;
    }

    /**
     * Remove version
     *
     * @param \MealSquare\RecetteBundle\Entity\Recette $version
     */
    public function removeVersion(\MealSquare\RecetteBundle\Entity\Recette $version)
    {
        if ($this->versions->contains($version)) {
            $version->setRecetteMere(null);
            $this->versions->removeElement($version);
        }
    }

    /**
     * Get versions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVersions()
    {
        return $this->versions;
    }

    /**
     * Set like
     *
     * @param \MealSquare\RecetteBundle\Entity\Like\LikeThread $like
     *
     * @return Recette
     */
    public function setLike(\MealSquare\RecetteBundle\Entity\Like\LikeThread $like = null)
    {
        $this->like = $like;

        return $this;
    }

    /**
     * Get like
     *
     * @return \MealSquare\RecetteBundle\Entity\Like\LikeThread
     */
    public function getLike()
    {
        return $this->like;
    }
}
