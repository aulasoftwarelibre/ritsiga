<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 31/05/15
 * Time: 18:00.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket.
 *
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\TicketRepository")
 * @ORM\Table(name="Ticket")
 */
class Ticket
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
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Convention", inversedBy="tickets") */
    private $convention;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="$startDate", type="date")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="$endDate", type="date")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Participant", mappedBy="ticket")
     */
    private $participants;

    /**
     * @var bool
     *
     * @ORM\Column(name="reduced", type="boolean", nullable=false, options={"default" = FALSE})
     */
    private $reduced;

    /**
     * @var bool
     *
     * @ORM\Column(name="public", type="boolean", nullable=false, options={"default" = TRUE})
     */
    private $public;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return Convention
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * @param Convention $convention
     */
    public function setConvention($convention)
    {
        $this->convention = $convention;
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
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
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
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * Return name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Add participant.
     *
     * @param \AppBundle\Entity\Participant $participant
     *
     * @return Ticket
     */
    public function addParticipant(\AppBundle\Entity\Participant $participant)
    {
        $this->participants[] = $participant;

        return $this;
    }

    /**
     * Remove participant.
     *
     * @param \AppBundle\Entity\Participant $participant
     */
    public function removeParticipant(\AppBundle\Entity\Participant $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * Get participants.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @return bool
     */
    public function isReduced()
    {
        return $this->reduced;
    }

    /**
     * @param bool $reduced
     */
    public function setReduced($reduced)
    {
        $this->reduced = $reduced;
    }

    /**
     * @return bool
     */
    public function isPublic()
    {
        return $this->public;
    }

    /**
     * @param bool $public
     */
    public function setPublic($public)
    {
        $this->public = $public;
    }
}
