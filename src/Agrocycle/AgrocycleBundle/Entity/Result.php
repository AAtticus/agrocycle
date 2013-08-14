<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\ResultRepository")
 * @ORM\Table(name="result")
 */
class Result {

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
     * @ORM\Column(type="integer")
     */
    protected $positive;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Project", mappedBy="results")
     **/
    protected $projects;
    
    /**
     * @ORM\ManyToMany(targetEntity="Research", mappedBy="results")
     **/
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
     * @return Result
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
     * Set positive
     *
     * @param integer $positive
     * @return Result
     */
    public function setPositive($positive)
    {
        $this->positive = $positive;
    
        return $this;
    }

    /**
     * Get positive
     *
     * @return integer 
     */
    public function getPositive()
    {
        return $this->positive;
    }

    /**
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Result
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
     * @return Result
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
     * @return Result
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