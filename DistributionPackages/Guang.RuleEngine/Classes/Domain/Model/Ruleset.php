<?php
namespace Guang\RuleEngine\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Ruleset
 * @Flow\Scope("prototype")
 * @Flow\Entity
 * @package Guang\RuleEngine\Domain\Model
 */
class Ruleset {

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
    protected $name;

    /**
     * @ORM\Column(type="text", length=100000)
     * @var string
     */
    protected $description;

    /**
     *
     * @ORM\Column(type="text", length=100000)
     * @var string
     */
    protected $rules;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param string $rules
     */
    public function setRules(string $rules)
    {
        $this->rules = $rules;
    }


}
