<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mission
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Mission
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
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable=true)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="runtime", type="time")
     */
    private $runtime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="need_buy", type="boolean", nullable=true)
     */
    private $needBuy;

    /**
     * @var integer
     *
     * @ORM\Column(name="costs", type="integer")
     */
    private $costs;

    /**
     * @var string
     *
     * @ORM\Column(name="icons", type="text")
     */
    private $icons;

    /**
     * @var string
     *
     * @ORM\Column(name="form", type="text", nullable=true)
     */
    private $form;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


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
     * Set type
     *
     * @param integer $type
     * @return Mission
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set runtime
     *
     * @param \DateTime $runtime
     * @return Mission
     */
    public function setRuntime($runtime)
    {
        $this->runtime = $runtime;
    
        return $this;
    }

    /**
     * Get runtime
     *
     * @return \DateTime 
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set needBuy
     *
     * @param boolean $needBuy
     * @return Mission
     */
    public function setNeedBuy($needBuy)
    {
        $this->needBuy = $needBuy;
    
        return $this;
    }

    /**
     * Get needBuy
     *
     * @return boolean 
     */
    public function getNeedBuy()
    {
        return $this->needBuy;
    }

    /**
     * Set costs
     *
     * @param integer $costs
     * @return Mission
     */
    public function setCosts($costs)
    {
        $this->costs = $costs;
    
        return $this;
    }

    /**
     * Get costs
     *
     * @return integer 
     */
    public function getCosts()
    {
        return $this->costs;
    }

    /**
     * Set icons
     *
     * @param string $icons
     * @return Mission
     */
    public function setIcons($icons)
    {
        $this->icons = $icons;
    
        return $this;
    }

    /**
     * Get icons
     *
     * @return string 
     */
    public function getIcons()
    {
        return $this->icons;
    }

    /**
     * Set form
     *
     * @param string $form
     * @return Mission
     */
    public function setForm($form)
    {
        $this->form = $form;
    
        return $this;
    }

    /**
     * Get form
     *
     * @return string 
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Mission
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
}