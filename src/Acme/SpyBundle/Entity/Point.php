<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Point
 *
 * @ORM\Table()
 * @ORM\Entity
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
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text", nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinates", type="string", length=100, nullable=true)
     */
    private $coordinates;

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
     * Set logo
     *
     * @param string $logo
     * @return Point
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @return string 
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set coordinates
     *
     * @param string $coordinates
     * @return Point
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
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
}