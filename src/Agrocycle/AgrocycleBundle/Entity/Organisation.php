<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\OrganisationRepository")
 * @ORM\Table(name="organisation")
 */
class Organisation {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
     /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $telephone;

    /**
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="organisations")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id")
     */
    protected $location;
    
    /**
    * @ORM\OneToMany(targetEntity="Project", mappedBy="organisation")
    */
    protected $projects;
    
    /**
    * @ORM\OneToMany(targetEntity="Research", mappedBy="organisation")
    */
    protected $researches;
    
   /**
    * @ORM\OneToMany(targetEntity="Person", mappedBy="organisation")
    */
    protected $persons;
    

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
     * Set name
     *
     * @param string $name
     * @return Organisation
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Organisation
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

    /**
     * Set email
     *
     * @param string $email
     * @return Organisation
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Organisation
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Organisation
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    
        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set location
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Location $location
     * @return Organisation
     */
    public function setLocation(\Agrocycle\AgrocycleBundle\Entity\Location $location = null)
    {
        $this->location = $location;
    
        return $this;
    }

    /**
     * Get location
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Location 
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Organisation
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
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $researches
     * @return Organisation
     */
    public function addResearche(\Agrocycle\AgrocycleBundle\Entity\Project $researches)
    {
        $this->researches[] = $researches;
    
        return $this;
    }

    /**
     * Remove researches
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $researches
     */
    public function removeResearche(\Agrocycle\AgrocycleBundle\Entity\Project $researches)
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
     * Add persons
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Person $persons
     * @return Organisation
     */
    public function addPerson(\Agrocycle\AgrocycleBundle\Entity\Person $persons)
    {
        $this->persons[] = $persons;
    
        return $this;
    }

    /**
     * Remove persons
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Person $persons
     */
    public function removePerson(\Agrocycle\AgrocycleBundle\Entity\Person $persons)
    {
        $this->persons->removeElement($persons);
    }

    /**
     * Get persons
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPersons()
    {
        return $this->persons;
    }
}