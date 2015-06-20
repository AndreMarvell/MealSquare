<?php

namespace MealSquare\RecetteBundle\Entity\Like;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="Likes")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Thread of this like
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="MealSquare\RecetteBundle\Entity\Like\LikeThread", cascade={"persist"})
     */
    protected $thread;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @var User
     */
    protected $liker;
    
    
    /**
     * Constructor
     */
    function __construct(LikeThread $thread, \Application\Sonata\UserBundle\Entity\User $liker) {
        $this->thread = $thread;
        $this->liker = $liker;
    }
    
    
    /**
     * @ORM\PrePersist
     */
    public function increase()
    {
        $this->thread->incrementNumLikes();
    }

    /**
     * @ORM\PreRemove
     */
    public function decrease()
    {
      $this->thread->decrementNumLikes();
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
     * Set thread
     *
     * @param \MealSquare\RecetteBundle\Entity\Like\LikeThread $thread
     * @return Like
     */
    public function setThread(\MealSquare\RecetteBundle\Entity\Like\LikeThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \MealSquare\RecetteBundle\Entity\Like\LikeThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set liker
     *
     * @param \Application\Sonata\UserBundle\Entity\User $liker
     * @return Like
     */
    public function setLiker(\Application\Sonata\UserBundle\Entity\User $liker = null)
    {
        $this->liker = $liker;

        return $this;
    }

    /**
     * Get liker
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getLiker()
    {
        return $this->liker;
    }
}
