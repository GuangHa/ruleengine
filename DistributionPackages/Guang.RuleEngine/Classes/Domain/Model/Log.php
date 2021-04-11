<?php
namespace Guang\RuleEngine\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Log
 * @Flow\Scope("prototype")
 * @Flow\Entity
 * @package Guang\RuleEngine\Domain\Model
 */
class Log {

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     */
    protected $datetime;

    /**
     * @var string
     */
    protected $logLevel;

    /**
     * @var string
     */
    protected $message;

    /**
     * @ORM\Column(type="text", length=100000)
     * @var string
     */
    protected $dataInput;

    /**
     *
     * @ORM\Column(type="text", length=100000)
     * @var string
     */
    protected $ruleInput;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getDataInput()
    {
        return $this->dataInput;
    }

    /**
     * @param string $dataInput
     */
    public function setDataInput(string $dataInput)
    {
        $this->dataInput = $dataInput;
    }

    /**
     * @return string
     */
    public function getRuleInput()
    {
        return $this->ruleInput;
    }

    /**
     * @param string $ruleInput
     */
    public function setRuleInput(string $ruleInput)
    {
        $this->ruleInput = $ruleInput;
    }

    /**
     * @return string
     */
    public function getLogLevel()
    {
        return $this->logLevel;
    }

    /**
     * @param string $logLevel
     */
    public function setLogLevel(string $logLevel)
    {
        $this->logLevel = $logLevel;
    }
}
