<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\ResearchRepository")
 * @ORM\Table(name="research")
 */
class Research {

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
     * @ORM\Column(type="string", length=255)
     */
    protected $website;
    
    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

   /**
     * @ORM\ManyToMany(targetEntity="Result", inversedBy="researches")
     * @ORM\JoinTable(name="results_researches")
     **/
    protected $results;
    
    /**
    * @ORM\OneToMany(targetEntity="Project", mappedBy="research")
    */
    protected $projects;
    
     /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="researches")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;
    
     /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="researches")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id")
     */
    protected $organisation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="researches")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    protected $subcategory;
    
    /**
     * @ORM\ManyToMany(targetEntity="Process")
     **/
    protected $secondaryFlow;
    
     /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $cycleExample;
    
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $duration;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $applicant;
    
     /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $financing;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $partners;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $notes;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
        $this->projects = new \Doctrine\Common\Collections\ArrayCollection();
        $this->secondaryFlow = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Research
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
     * Add results
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Result $results
     * @return Research
     */
    public function addResult(\Agrocycle\AgrocycleBundle\Entity\Result $results)
    {
        $this->results[] = $results;
    
        return $this;
    }

    /**
     * Remove results
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Result $results
     */
    public function removeResult(\Agrocycle\AgrocycleBundle\Entity\Result $results)
    {
        $this->results->removeElement($results);
    }

    /**
     * Get results
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Add projects
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Project $projects
     * @return Research
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
     * Set person
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Person $person
     * @return Research
     */
    public function setPerson(\Agrocycle\AgrocycleBundle\Entity\Person $person = null)
    {
        $this->person = $person;
    
        return $this;
    }

    /**
     * Get person
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Person 
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * Set organisation
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $organisation
     * @return Research
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

    /**
     * Add secondaryFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $secondaryFlow
     * @return Research
     */
    public function addSecondaryFlow(\Agrocycle\AgrocycleBundle\Entity\Process $secondaryFlow)
    {
        $this->secondaryFlow[] = $secondaryFlow;
    
        return $this;
    }

    /**
     * Remove secondaryFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $secondaryFlow
     */
    public function removeSecondaryFlow(\Agrocycle\AgrocycleBundle\Entity\Process $secondaryFlow)
    {
        $this->secondaryFlow->removeElement($secondaryFlow);
    }

    /**
     * Get secondaryFlow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSecondaryFlow()
    {
        return $this->secondaryFlow;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Research
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
     * Set duration
     *
     * @param string $duration
     * @return Research
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    
        return $this;
    }

    /**
     * Get duration
     *
     * @return string 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set applicant
     *
     * @param string $applicant
     * @return Research
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;
    
        return $this;
    }

    /**
     * Get applicant
     *
     * @return string 
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Set financing
     *
     * @param string $financing
     * @return Research
     */
    public function setFinancing($financing)
    {
        $this->financing = $financing;
    
        return $this;
    }

    /**
     * Get financing
     *
     * @return string 
     */
    public function getFinancing()
    {
        return $this->financing;
    }

    /**
     * Set partners
     *
     * @param string $partners
     * @return Research
     */
    public function setPartners($partners)
    {
        $this->partners = $partners;
    
        return $this;
    }

    /**
     * Get partners
     *
     * @return string 
     */
    public function getPartners()
    {
        return $this->partners;
    }

    /**
     * Set notes
     *
     * @param string $notes
     * @return Research
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    
        return $this;
    }

    /**
     * Get notes
     *
     * @return string 
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set cycleExample
     *
     * @param string $cycleExample
     * @return Research
     */
    public function setCycleExample($cycleExample)
    {
        $this->cycleExample = $cycleExample;
    
        return $this;
    }

    /**
     * Get cycleExample
     *
     * @return string 
     */
    public function getCycleExample()
    {
        return $this->cycleExample;
    }

    /**
     * Set subcategory
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Subcategory $subcategory
     * @return Research
     */
    public function setSubcategory(\Agrocycle\AgrocycleBundle\Entity\Subcategory $subcategory = null)
    {
        $this->subcategory = $subcategory;
    
        return $this;
    }

    /**
     * Get subcategory
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Subcategory 
     */
    public function getSubcategory()
    {
        return $this->subcategory;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Research
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
}