<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 19/04/15
 * Time: 19:53.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Registration.
 *
 * @ORM\Entity
 * @ORM\Table(name="Participant")
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\ParticipantRepository")
 * @UniqueEntity(
 *      fields={"dni", "registration"},
 *      repositoryMethod="findUniqueParticipant",
 *      errorPath="dni",
 *      message="error.duplicate_dni"
 * )
 */
class Participant
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255)
     * @Assert\NotBlank
     */
    private $last_name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(name="phone", type="integer", length=20, nullable=true)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="dni", type="string", length=9)
     * @Assert\NotBlank
     */
    private $dni;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=5, nullable=true)
     */
    private $size;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     * @Assert\NotBlank
     */
    private $dateOfBirth;

    /**
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\Registration", inversedBy="participants")
     */
    private $registration;

    /** @ORM\ManyToOne(
     * targetEntity="\AppBundle\Entity\Ticket",
     * inversedBy="participants"
     * )
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     */
    private $ticket;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"name", "last_name"}, unique=true, updatable=true)
     */
    private $slug;

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
     * Set name.
     *
     * @param string $name
     *
     * @return Participant
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
     * Set lastName.
     *
     * @param string $lastName
     *
     * @return Participant
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;

        return $this;
    }

    /**
     * Get lastName.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Participant
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set dni.
     *
     * @param string $dni
     *
     * @return Participant
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni.
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set registration.
     *
     * @param \AppBundle\Entity\Registration $registration
     *
     * @return Participant
     */
    public function setRegistration(Registration $registration = null)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration.
     *
     * @return \AppBundle\Entity\Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param int $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @param \DateTime $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * To String.
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s %s', $this->getName(), $this->getLastName());
    }
}
