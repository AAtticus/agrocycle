<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\ProjectRepository")
 * @ORM\Table(name="project")
 */
class Project {

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
     * @ORM\Column(type="text")
     */
    protected $source;

    /**
     * @ORM\Column(type="string", length=3)
     */
    protected $is_bio;
    
    /**
     * @ORM\ManyToOne(targetEntity="Organisation", inversedBy="projects")
     * @ORM\JoinColumn(name="organisation_id", referencedColumnName="id", nullable=true)
     */
    protected $organisation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Person", inversedBy="projects")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id", nullable=true)
     */
    protected $person;
    
    /**
     * @ORM\ManyToOne(targetEntity="Research", inversedBy="projects")
     * @ORM\JoinColumn(name="research_id", referencedColumnName="id", nullable=true)
     */
    protected $research;
    
    /**
     * @ORM\ManyToOne(targetEntity="Subcategory", inversedBy="projects")
     * @ORM\JoinColumn(name="subcategory_id", referencedColumnName="id")
     */
    protected $subcategory;
    
    /**
     * @ORM\ManyToOne(targetEntity="Sector", inversedBy="projects")
     * @ORM\JoinColumn(name="sector_id", referencedColumnName="id")
     */
    protected $sector;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $primaryActivity;
    
    /**
     * @ORM\ManyToMany(targetEntity="Process")
     **/
    protected $primaryFlow;
    
    /**
     * @ORM\ManyToMany(targetEntity="Process")
     * @ORM\JoinTable(name="projects_secondaryflows")
     **/
    protected $secondaryFlow;
    
    /**
     * @ORM\ManyToMany(targetEntity="Process")
     * @ORM\JoinTable(name="projects_externalflows")
     **/
    protected $externalFlow;
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $secondaryCycleExample;
    
      /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $cycleExample;
    
    /**
     * @ORM\ManyToMany(targetEntity="Result", inversedBy="projects")
     * @ORM\JoinTable(name="projects_results")
     **/
    protected $results;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $inspiration;
    
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $extraInformation;
    
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->primaryFlow = new \Doctrine\Common\Collections\ArrayCollection();
        $this->secondaryFlow = new \Doctrine\Common\Collections\ArrayCollection();
        $this->externalFlow = new \Doctrine\Common\Collections\ArrayCollection();
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->results = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Project
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
     * Set source
     *
     * @param string $source
     * @return Project
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
     * Set is_bio
     *
     * @param string $isBio
     * @return Project
     */
    public function setIsBio($isBio)
    {
        $this->is_bio = $isBio;
    
        return $this;
    }

    /**
     * Get is_bio
     *
     * @return string 
     */
    public function getIsBio()
    {
        return $this->is_bio;
    }

    /**
     * Set primaryActivity
     *
     * @param string $primaryActivity
     * @return Project
     */
    public function setPrimaryActivity($primaryActivity)
    {
        $this->primaryActivity = $primaryActivity;
    
        return $this;
    }

    /**
     * Get primaryActivity
     *
     * @return string 
     */
    public function getPrimaryActivity()
    {
        return $this->primaryActivity;
    }

    /**
     * Set secondaryCycleExample
     *
     * @param string $secondaryCycleExample
     * @return Project
     */
    public function setSecondaryCycleExample($secondaryCycleExample)
    {
        $this->secondaryCycleExample = $secondaryCycleExample;
    
        return $this;
    }

    /**
     * Get secondaryCycleExample
     *
     * @return string 
     */
    public function getSecondaryCycleExample()
    {
        return $this->secondaryCycleExample;
    }

    /**
     * Set inspiration
     *
     * @param string $inspiration
     * @return Project
     */
    public function setInspiration($inspiration)
    {
        $this->inspiration = $inspiration;
    
        return $this;
    }

    /**
     * Get inspiration
     *
     * @return string 
     */
    public function getInspiration()
    {
        return $this->inspiration;
    }

    /**
     * Set extraInformation
     *
     * @param string $extraInformation
     * @return Project
     */
    public function setExtraInformation($extraInformation)
    {
        $this->extraInformation = $extraInformation;
    
        return $this;
    }

    /**
     * Get extraInformation
     *
     * @return string 
     */
    public function getExtraInformation()
    {
        return $this->extraInformation;
    }

    /**
     * Set organisation
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $organisation
     * @return Project
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
     * Set person
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Person $person
     * @return Project
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
     * Set research
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Research $research
     * @return Project
     */
    public function setResearch(\Agrocycle\AgrocycleBundle\Entity\Research $research = null)
    {
        $this->research = $research;
    
        return $this;
    }

    /**
     * Get research
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Research 
     */
    public function getResearch()
    {
        return $this->research;
    }

    /**
     * Set location
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Location $location
     * @return Project
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
     * Set subcategory
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Subcategory $subcategory
     * @return Project
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
     * Set sector
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Sector $sector
     * @return Project
     */
    public function setSector(\Agrocycle\AgrocycleBundle\Entity\Sector $sector = null)
    {
        $this->sector = $sector;
    
        return $this;
    }

    /**
     * Get sector
     *
     * @return \Agrocycle\AgrocycleBundle\Entity\Sector 
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Add primaryFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $primaryFlow
     * @return Project
     */
    public function addPrimaryFlow(\Agrocycle\AgrocycleBundle\Entity\Process $primaryFlow)
    {
        $this->primaryFlow[] = $primaryFlow;
    
        return $this;
    }

    /**
     * Remove primaryFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $primaryFlow
     */
    public function removePrimaryFlow(\Agrocycle\AgrocycleBundle\Entity\Process $primaryFlow)
    {
        $this->primaryFlow->removeElement($primaryFlow);
    }

    /**
     * Get primaryFlow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrimaryFlow()
    {
        return $this->primaryFlow;
    }

    /**
     * Add secondaryFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $secondaryFlow
     * @return Project
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
     * Add externalFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $externalFlow
     * @return Project
     */
    public function addExternalFlow(\Agrocycle\AgrocycleBundle\Entity\Process $externalFlow)
    {
        $this->externalFlow[] = $externalFlow;
    
        return $this;
    }

    /**
     * Remove externalFlow
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Process $externalFlow
     */
    public function removeExternalFlow(\Agrocycle\AgrocycleBundle\Entity\Process $externalFlow)
    {
        $this->externalFlow->removeElement($externalFlow);
    }

    /**
     * Get externalFlow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getExternalFlow()
    {
        return $this->externalFlow;
    }

    /**
     * Add products
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Subcategory $products
     * @return Project
     */
    public function addProduct(\Agrocycle\AgrocycleBundle\Entity\Subcategory $products)
    {
        $this->products[] = $products;
    
        return $this;
    }

    /**
     * Remove products
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Subcategory $products
     */
    public function removeProduct(\Agrocycle\AgrocycleBundle\Entity\Subcategory $products)
    {
        $this->products->removeElement($products);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add results
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Result $results
     * @return Project
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
     * Set slug
     *
     * @param string $slug
     * @return Project
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
     * Set cycleExample
     *
     * @param string $cycleExample
     * @return Project
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
}