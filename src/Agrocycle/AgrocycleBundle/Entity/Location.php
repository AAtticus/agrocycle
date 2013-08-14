<?php

namespace Agrocycle\AgrocycleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo; 

/**
 * @ORM\Entity(repositoryClass="Agrocycle\AgrocycleBundle\Repository\LocationRepository")
 * @ORM\Table(name="location")
 */
class Location {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

      /**
     * @ORM\Column(type="string", length=100)
     */
    protected $address;

    /**
     * @ORM\Column(type="integer")
     */
    protected $number;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $postcode;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $city;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $country;

    /**
    * @ORM\Column(type="decimal", precision=18, scale=12)
    */
    protected $longitude;
    
    /**
    * @ORM\Column(type="decimal", precision=18, scale=12)
    */
    protected $lattitude;
    
    /**
    * @ORM\OneToMany(targetEntity="Organisation", mappedBy="location")
    */
    protected $organisations;
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->organisations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set address
     *
     * @param string $address
     * @return Location
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Location
     */
    public function setNumber($number)
    {
        $this->number = $number;
    
        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Location
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    
        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;
    
        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Location
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set lattitude
     *
     * @param float $lattitude
     * @return Location
     */
    public function setLattitude($lattitude)
    {
        $this->lattitude = $lattitude;
    
        return $this;
    }

    /**
     * Get lattitude
     *
     * @return float 
     */
    public function getLattitude()
    {
        return $this->lattitude;
    }

    /**
     * Add organisations
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $organisations
     * @return Location
     */
    public function addOrganisation(\Agrocycle\AgrocycleBundle\Entity\Organisation $organisations)
    {
        $this->organisations[] = $organisations;
    
        return $this;
    }

    /**
     * Remove organisations
     *
     * @param \Agrocycle\AgrocycleBundle\Entity\Organisation $organisations
     */
    public function removeOrganisation(\Agrocycle\AgrocycleBundle\Entity\Organisation $organisations)
    {
        $this->organisations->removeElement($organisations);
    }

    /**
     * Get organisations
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrganisations()
    {
        return $this->organisations;
    }
    
    /**
     * Get Coordinates
     */
    public function getCoordinates()
    {
        return null;
    }
    
    public function  __toString() {
        return $this->getAddress(). ' ' . $this->getNumber(). ' ' .$this->getPostcode() . ' ' . $this->getCity() . ', ' . $this->getCountry();
    }
}