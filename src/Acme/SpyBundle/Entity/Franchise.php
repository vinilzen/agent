<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Franchise
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Franchise
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
     * @ORM\Column(name="brand", type="string", length=100)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="string", length=100, nullable=true)
     */
    private $logo;

    /**
     * @var string
     *
     * @ORM\Column(name="industry", type="string", length=100)
     */
    private $industry;

    /**
     * @ORM\OneToMany(targetEntity="Point", mappedBy="franchise")
     */
    protected $points;

    public function __construct()
    {
        $this->points = new ArrayCollection();
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
     * Set brand
     *
     * @param string $brand
     * @return Franchise
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set industry
     *
     * @param string $industry
     * @return Franchise
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
    
        return $this;
    }

    /**
     * Get industry
     *
     * @return string 
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * Add points
     *
     * @param \Acme\SpyBundle\Entity\Point $points
     * @return Franchise
     */
    public function addPoint(\Acme\SpyBundle\Entity\Point $points)
    {
        $this->points[] = $points;
    
        return $this;
    }

    /**
     * Remove points
     *
     * @param \Acme\SpyBundle\Entity\Point $points
     */
    public function removePoint(\Acme\SpyBundle\Entity\Point $points)
    {
        $this->points->removeElement($points);
    }

    /**
     * Get points
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPoints()
    {
        return $this->points;
    }

    function __toString()
    {
        return (string)$this->getBrand();
    }

    /**
     * Set logo
     *
     * @param string $logo
     * @return Franchise
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    
        return $this;
    }

    /**
     * Get logo
     *
     * @param Boolean $absolute
     *
     * @return string 
     */
    public function getLogo($absolute = false)
    {
        if ('' == $this->logo || null === $this->logo) {
            return '';
        }

        return self::getLogoPath($absolute).'/'.$this->logo;
    }


    /**
     * Get logo storage path
     *
     * @param Boolean $absolute
     *
     * @return string
     */
    public static function getLogoPath($absolute = false)
    {
        $path = '';
        if ($absolute) {
            $path = realpath(__DIR__.'/../../../../../web').'/';
        }

        return $path.'uploads/logo';
    }
}