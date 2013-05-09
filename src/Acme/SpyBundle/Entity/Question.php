<?php

namespace Acme\SpyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Question
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
     * текст вопроса
     * @ORM\Column(name="question", type="text")
     */
    private $question;

    /**
     * @var integer
     *
     * @ORM\Column(name="limitAnswer", type="integer", nullable=true)
     */
    private $limitAnswer = 1;

    /**
     * @var array
     *
     * @ORM\Column(name="answers", type="string", nullable=true)
     */
    private $answers = '';

    /**
     * @var $mission
     *
     * @ORM\ManyToOne(targetEntity="Mission", inversedBy="questions")
     * @ORM\JoinColumn(name="mission_id", referencedColumnName="id")
     *
     */
    protected $mission;


    /**
     * @ORM\ManyToOne(targetEntity="QuestionType")
     * @ORM\JoinColumn(name="questionType_id", referencedColumnName="id")
     */
    protected $questionType;

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
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    function __toString()
    {
        return (string)$this->question;
    }

    /**
     * Set answers
     *
     * @param array $answers
     * @return Question
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    
        return $this;
    }

    /**
     * Get answers
     *
     * @return array 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set mission
     *
     * @param \Acme\SpyBundle\Entity\Mission $mission
     * @return Question
     */
    public function setMission(\Acme\SpyBundle\Entity\Mission $mission)
    {
        $this->mission = $mission;
    
        return $this;
    }

    /**
     * Get mission
     *
     * @return \Acme\SpyBundle\Entity\Mission 
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * Set questionType
     *
     * @param \Acme\SpyBundle\Entity\QuestionType $questionType
     * @return Question
     */
    public function setQuestionType(\Acme\SpyBundle\Entity\QuestionType $questionType = null)
    {
        $this->questionType = $questionType;
    
        return $this;
    }

    /**
     * Get questionType
     *
     * @return \Acme\SpyBundle\Entity\QuestionType 
     */
    public function getQuestionType()
    {
        return $this->questionType;
    }

    /**
     * Set limitAnswer
     *
     * @param integer $limitAnswer
     * @return Question
     */
    public function setLimitAnswer($limitAnswer)
    {
        $this->limitAnswer = $limitAnswer;
    
        return $this;
    }

    /**
     * Get limitAnswer
     *
     * @return integer 
     */
    public function getLimitAnswer()
    {
        return $this->limitAnswer;
    }
}