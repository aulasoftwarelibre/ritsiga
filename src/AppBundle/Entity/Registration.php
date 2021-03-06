<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 19/04/15
 * Time: 19:52.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Registration.
 *
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\RegistrationRepository")
 * @ORM\Table(name="Registration")
 */
class Registration
{
    const STATUS_INIT = 'init';
    const STATUS_OPEN = 'open';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=140)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $position;

    /**
     * @ORM\ManyToOne(
     *   targetEntity="\AppBundle\Entity\User",
     *   inversedBy="registrations"
     * )
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     */
    private $user;

    /** @ORM\ManyToOne(
     *   targetEntity="\AppBundle\Entity\Convention",
     *   inversedBy="registrations"
     * )
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     */
    private $convention;

    /**
     * @ORM\OneToMany(targetEntity="Participant",mappedBy="registration")
     */
    private $participants;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=45, nullable=false)
     * @Assert\Choice(choices={"open", "confirmed", "paid", "cancelled", "init"})
     * @Serializer\Exclude
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="departure_date", type="datetime", nullable=true)
     */
    private $departuredate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arrival_date", type="datetime", nullable=true)
     */
    private $arrivaldate;

    /**
     * @var string
     *
     * @ORM\Column(name="transport", type="string", length=100, nullable=true)
     */
    private $transport;

    /**
     * @var string
     *
     * @ORM\Column(name="comentary", type="text", length=100, nullable=true)
     */
    private $comentary;

    /**
     * @var TaxData
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\TaxData", mappedBy="registration", cascade={"persist"})
     * @Assert\Valid()
     */
    private $taxdata;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created_at;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated_at;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Registration
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set convention.
     *
     * @param \AppBundle\Entity\Convention $convention
     *
     * @return Registration
     */
    public function setConvention(\AppBundle\Entity\Convention $convention = null)
    {
        $this->convention = $convention;

        return $this;
    }

    /**
     * Get convention.
     *
     * @return \AppBundle\Entity\Convention
     */
    public function getConvention()
    {
        return $this->convention;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->participants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->status = self::STATUS_INIT;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Registration
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set position.
     *
     * @param string $position
     *
     * @return Registration
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Add participant.
     *
     * @param \AppBundle\Entity\Participant $participant
     *
     * @return Registration
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        if (!in_array($status, self::getStatuses())) {
            throw new \InvalidArgumentException('Wrong status type supplied.');
        }
        $this->status = $status;

        return $this;
    }

    /**
     * Get all status values.
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_OPEN,
            self::STATUS_PAID,
            self::STATUS_CONFIRMED,
            self::STATUS_CANCELLED,
            self::STATUS_INIT,
        ];
    }

    /**
     * Get amount.
     *
     * @return float
     */
    public function getAmount()
    {
        $participants = $this->getParticipants();
        $amount = 0;
        foreach ($participants as $participant) {
            $amount += $participant->getTicket()->getPrice();
        }

        return $amount;
    }

    /**
     * @return \DateTime
     */
    public function getDeparturedate()
    {
        return $this->departuredate;
    }

    /**
     * @param \DateTime $departuredate
     */
    public function setDeparturedate($departuredate)
    {
        $this->departuredate = $departuredate;
    }

    /**
     * @return \DateTime
     */
    public function getArrivaldate()
    {
        return $this->arrivaldate;
    }

    /**
     * @param \DateTime $arrivaldate
     */
    public function setArrivaldate($arrivaldate)
    {
        $this->arrivaldate = $arrivaldate;
    }

    /**
     * @return string
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param string $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;
    }

    /**
     * @return string
     */
    public function getComentary()
    {
        return $this->comentary;
    }

    /**
     * @param string $comentary
     */
    public function setComentary($comentary)
    {
        $this->comentary = $comentary;
    }

    /**
     * Get registration description.
     *
     * @return string
     */
    public function getDescription()
    {
        return sprintf('#%d - %s - %s', $this->getId(), $this->getUser()->getUniversity(), $this->getUser());
    }

    /**
     * @param ExecutionContextInterface $context
     * @Assert\Callback(groups={"travel"})
     */
    public function validateTravel(ExecutionContextInterface $context)
    {
        if (!$this->getArrivaldate() || !$this->getDeparturedate()) {
            return;
        }

        if ($this->getDeparturedate() < $this->getArrivaldate()) {
            $context->buildViolation('error.travel_date_incorrect')
                ->atPath('arrivaldate')
                ->addViolation()
            ;
        }
    }

    /**
     * @return TaxData
     */
    public function getTaxdata()
    {
        return $this->taxdata;
    }

    /**
     * @param TaxData $taxdata
     */
    public function setTaxdata($taxdata)
    {
        $this->taxdata = $taxdata;
        $taxdata->setRegistration($this);
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param \DateTime $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public static function getStatusArrayChoice()
    {
        return [
            self::STATUS_OPEN => 'status.open',
            self::STATUS_CONFIRMED => 'status.confirmed',
            self::STATUS_CANCELLED => 'status.cancelled',
            self::STATUS_PAID => 'status.paid',
        ];
    }

    public function isOpen()
    {
        return $this->getStatus() === self::STATUS_OPEN;
    }

    /**
     * Get Registration name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}
