<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\PersonRepository")
 * @ORM\Table(name="person")
 */
class Person {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $email;
    
    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    protected $telephone;
    
    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="persons")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     */
    protected $organisation;
    
    /**
    * @ORM\OneToMany(targetEntity="Project", mappedBy="person")
    */
    protected $projects;
    
    /**
    * @ORM\OneToMany(targetEntity="Research", mappedBy="person")
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
     * Set firstName
     *
     * @param string $firstName
     * @return Person
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Person
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Person
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
     * Set telephone
     *
     * @param string $telephone
     * @return Person
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
     * Set category
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $category
     * @return Person
     */
    public function setCategory(\Agrocycle\AgrocycleBundle\Entity\Organisation $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Organisation 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Person
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
     * @return Person
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
     * Set organisation
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $organisation
     * @return Person
     */
    public function setOrganisation(\Agrocycle\AgrocycleBundle\Entity\Organisation $organisation = null)
    {
        $this->organisation = $organisation;
    
        return $this;
    }

    /**
     * Get organisation
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Organisation 
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }
    
    public function __toString() {
        return $this->getFirstName() . ' ' .$this->getLastName();
    }
}