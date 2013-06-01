<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MissionAccomplished
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class MissionAccomplished
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
     * @var string
     *
     * @ORM\Column(name="info", type="text")
     */
    private $info;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="files", type="text")
     */
    private $files;

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
     * Set info
     *
     * @param string $info
     * @return MissionAccomplished
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return MissionAccomplished
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Set files
     *
     * @param string $files
     * @return MissionAccomplished
     */
    public function setFiles($files)
    {
        $this->files = $files;
    
        return $this;
    }

    /**
     * Get files
     *
     * @return string 
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return MissionAccomplished
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
     * @return MissionAccomplished
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
}