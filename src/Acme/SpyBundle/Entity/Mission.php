<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var \DateTime
     *
     * @ORM\Column(name="runtime", type="time")
     */
    private $runtime;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="MissionType")
     * @ORM\JoinColumn(name="missionType_id", referencedColumnName="id")
     */
    protected $missionType;

    /**
     * @ORM\ManyToOne(targetEntity="Point", inversedBy="missions")
     * @ORM\JoinColumn(name="point_id", referencedColumnName="id")
     */
    protected $point;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="mission", cascade={"all"}, orphanRemoval=true)
     */
    protected $questions;



    function __construct()
    {
       $this->questions = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set missionType
     *
     * @param \Acme\SpyBundle\Entity\MissionType $missionType
     * @return Mission
     */
    public function setMissionType(\Acme\SpyBundle\Entity\MissionType $missionType = null)
    {
        $this->missionType = $missionType;
    
        return $this;
    }

    /**
     * Get missionType
     *
     * @return \Acme\SpyBundle\Entity\MissionType 
     */
    public function getMissionType()
    {
        return $this->missionType;
    }

    /**
     * Set point
     *
     * @param \Acme\SpyBundle\Entity\Point $point
     * @return Mission
     */
    public function setPoint(\Acme\SpyBundle\Entity\Point $point = null)
    {
        $this->point = $point;
    
        return $this;
    }

    /**
     * Get point
     *
     * @return \Acme\SpyBundle\Entity\Point 
     */
    public function getPoint()
    {
        return $this->point;
    }
    
    function __toString()
    {
        return (string)$this->getDescription();
    }

    /**
     * Add questions
     *
     * @param \Acme\SpyBundle\Entity\Question $questions
     * @return Mission
     */
    public function addQuestion(\Acme\SpyBundle\Entity\Question $questions)
    {
        $this->questions[] = $questions;
    
        return $this;
    }

    /**
     * Remove questions
     *
     * @param \Acme\SpyBundle\Entity\Question $questions
     */
    public function removeQuestion(\Acme\SpyBundle\Entity\Question $questions)
    {
        $this->questions->removeElement($questions);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set questions
     *
     * @param \Acme\SpyBundle\Entity\Question $questions
     * @return Mission
     */
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        foreach ($this->questions as $pos => $question)
        {
            /*var_dump($question);
            var_dump($pos);
            var_dump($this);*/
            $question->setMission($this);
        }
        //die('xxx');
        return $this;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Mission
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