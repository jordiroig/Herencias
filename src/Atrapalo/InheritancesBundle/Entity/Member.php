<?php

namespace Atrapalo\InheritancesBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Member
 *
 * @ORM\Table(name="member")
 * @ORM\Entity(repositoryClass="Atrapalo\InheritancesBundle\Repository\MemberRepository")
 */
class Member
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="birthdate", type="date")
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, unique=true)
     */
    private $name;

    /**
     * @var Member
     *
     * @ORM\ManyToOne(targetEntity="Atrapalo\InheritancesBundle\Entity\Member", inversedBy="sons")
     * @ORM\JoinColumn(name="father", referencedColumnName="id", nullable=true)
     */
    private $father;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Atrapalo\InheritancesBundle\Entity\Member", mappedBy="father", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $sons;

    /**
     * @var integer
     *
     * @ORM\Column(name="lands", type="integer", nullable=false, options={"default":0})
     */
    private $lands = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="money", type="decimal", precision=10, scale=0, nullable=false, options={"default":0})
     */
    private $money = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="properties", type="integer", nullable=false, options={"default":0})
     */
    private $properties = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sons = new ArrayCollection();
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
     * Set birthdate
     *
     * @param DateTime $birthdate
     * @return Member
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return DateTime
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Member
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set father
     *
     * @param Member $father
     * @return Member
     */
    public function setFather(Member $father)
    {
        $this->father = $father;
        return $this;
    }
    /**
     * Get father
     *
     * @return Member
     */
    public function getFather()
    {
        return $this->father;
    }

    /**
     * Set sons
     *
     * @param Collection $sons
     * @return Member
     */
    public function setSons(Collection $sons)
    {
        if (count($sons) > 0) foreach ($sons as $son) $this->addSon($son);
        return $this;
    }
    /**
     * Add son
     *
     * @param Member $son
     * @return Member
     */
    public function addSon(Member $son)
    {
        $son->setFather($this);
        $this->getSons()->add($son);
        return $this;
    }
    /**
     * Remove son
     *
     * @param Member $son
     */
    public function removeSon(Member $son)
    {
        $this->sons->removeElement($son);
    }
    /**
     * Get sons
     *
     * @return Collection
     */
    public function getSons()
    {
        return $this->sons;
    }

    /**
     * Get lands
     *
     * @return int
     */
    public function getLands()
    {
        return $this->lands;
    }

    /**
     * Set lands
     *
     * @param int $lands
     * @return Member
     */
    public function setLands($lands)
    {
        $this->lands = $lands;
        return $this;
    }

    /**
     * Get money
     *
     * @return float
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set money
     *
     * @param float $money
     * @return $this
     */
    public function setMoney($money)
    {
        $this->money = $money;
        return $this;
    }

    /**
     * Get properties
     *
     * @return int
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * Set properties
     *
     * @param int $properties
     * @return $this
     */
    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }
}
