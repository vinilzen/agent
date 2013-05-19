<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Point
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Acme\SpyBundle\Entity\PointRepository")
 */
class Point
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var decimal
     *
     * @ORM\Column(name="latitude", type="text", length=9)
     */
    private $latitude;

    /**
     * @var decimal
     *
     * @ORM\Column(name="longitude", type="text", length=9)
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="Franchise", inversedBy="points")
     * @ORM\JoinColumn(name="franchise_id", referencedColumnName="id")
     */
    protected $franchise;

    /**
     * @ORM\OneToMany(targetEntity="Mission", mappedBy="point", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"description" = "ASC"})
     */
    protected $missions;



    function __construct()
    {
       $this->missions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Point
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
     * Set description
     *
     * @param string $description
     * @return Point
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }


    /**
     * Set franchise
     *
     * @param \Acme\SpyBundle\Entity\Franchise $franchise
     * @return Point
     */
    public function setFranchise(\Acme\SpyBundle\Entity\Franchise $franchise = null)
    {
        $this->franchise = $franchise;
    
        return $this;
    }

    /**
     * Get franchise
     *
     * @return \Acme\SpyBundle\Entity\Franchise 
     */
    public function getFranchise()
    {
        return $this->franchise;
    }
    
    function __toString()
    {
        return (string)$this->getTitle();
    }

    /**
     * Add missions
     *
     * @param \Acme\SpyBundle\Entity\Mission $missions
     * @return Point
     */
    public function addMission(\Acme\SpyBundle\Entity\Mission $missions)
    {
        $this->missions[] = $missions;
    
        return $this;
    }

    /**
     * Remove missions
     *
     * @param \Acme\SpyBundle\Entity\Mission $missions
     */
    public function removeMission(\Acme\SpyBundle\Entity\Mission $missions)
    {
        $this->missions->removeElement($missions);
    }

    /**
     * Get missions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMissions()
    {
        return $this->missions;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Point
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Point
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Point
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
}