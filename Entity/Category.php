<?php
/* 
 *  Matteo Giachino <m.giachino@vivacom.com>
 *  Vivacom 2011
 *  Just for fun...
 */

namespace Bundle\BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Bundle\BlogBundle\BlogBundle;

/**
 * @orm:Entity
 * @orm:Table(name="blog_categories")
 */
class Category {
    /**
     * @orm:Column(type="integer")
     * @orm:Id
     * @orm:GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @orm:Column(unique="true")
     */
    private $name;

    /**
     * @orm:Column
     */
    private $slug;

    /**
     * @orm:OneToMany(targetEntity="Post", mappedBy="category")
     */
    private $posts;
    
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        if (null === $this->slug) {
            $this->slug = BlogBundle::slugify($name);
        }
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add posts
     *
     * @param Bundle\BlogBundle\Entity\Post $posts
     */
    public function addPosts(\Bundle\BlogBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;
    }

    /**
     * Get posts
     *
     * @return Doctrine\Common\Collections\Collection $posts
     */
    public function getPosts()
    {
        return $this->posts;
    }
    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string $slug
     */
    public function getSlug()
    {
        return $this->slug;
    }
}