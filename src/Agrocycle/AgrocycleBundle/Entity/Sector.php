<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\SectorRepository")
 * @ORM\Table(name="sector")
 */
class Sector {

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
    * @ORM\OneToMany(targetEntity="Project", mappedBy="sector")
    */
    protected $projects;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Sector
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
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Sector
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
     * Set slug
     *
     * @param string $slug
     * @return Sector
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