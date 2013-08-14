<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\SubcategoryRepository")
 * @ORM\Table(name="subcategory")
 */
class Subcategory {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="subcategories")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    
    /**
    * @ORM\OneToMany(targetEntity="Project", mappedBy="subcategory")
    */
    protected $projects;
    
    /**
    * @ORM\OneToMany(targetEntity="Research", mappedBy="subcategory")
    */
    protected $researches;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->researches = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     * @return Subcategory
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set category
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Category $category
     * @return Subcategory
     */
    public function setCategory(\Agrocycle\AgrocycleBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Subcategory
     */
    public function addProject(\Agrocycle\AgrocycleBundle\Entity\Project $projects)
    {
        $this->projects[] = $projects;
    
        return $this;
    }

    /**
     * Remove projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     */
    public function removeProject(\Agrocycle\AgrocycleBundle\Entity\Project $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Add researches
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Research $researches
     * @return Subcategory
     */
    public function addResearche(\Agrocycle\AgrocycleBundle\Entity\Research $researches)
    {
        $this->researches[] = $researches;
    
        return $this;
    }

    /**
     * Remove researches
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Research $researches
     */
    public function removeResearche(\Agrocycle\AgrocycleBundle\Entity\Research $researches)
    {
        $this->researches->removeElement($researches);
    }

    /**
     * Get researches
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResearches()
    {
        return $this->researches;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Subcategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
}