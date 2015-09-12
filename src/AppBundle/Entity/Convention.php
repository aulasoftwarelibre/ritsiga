<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Convention
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\ConventionRepository")
 * @Gedmo\Uploadable(filenameGenerator="SHA1", path="../web/images")
 */
class Convention
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
     *
     * @ORM\Column(name="name", type="string", length=512)
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     */
    private $web;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     * @Gedmo\UploadableFileName
     */
    private $image;

    /**
     * @ORM\Column(name="mime_type", type="string", nullable=true)
     * @Gedmo\UploadableFileMimeType
     */
    private $mimeType;

    /**
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="starts_at", type="datetime")
     * @Assert\NotBlank
     */
    private $startsAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ends_at", type="datetime")
     * @Assert\NotBlank
     */
    private $endsAt;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="maintenance", type="boolean", nullable=false)
     */
    private $maintenance = true;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="Registration",mappedBy="convention")
     */
    private $registrations;

    /**
     * @ORM\ManyToMany(
     *  targetEntity="User",
     *  inversedBy="admin_conventions"
     * )
     * @ORM\JoinTable(
     *  name="ConventionAdministrators",
     *  joinColumns={
     *      @ORM\JoinColumn(
     *          name="convention_id",
     *          referencedColumnName="id",
     *          nullable=false,
     *      )
     *  },
     *  inverseJoinColumns={
     *      @ORM\JoinColumn(
     *          name="user_id",
     *          referencedColumnName="id",
     *          nullable=false,
     *      )
     *  }
     * )
     */
    private $administrators;

    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;
    /**
     * @var string
     *
     * @ORM\Column(name="instagram", type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ParticipantType", mappedBy="convention")
     */
    private $participants_types;

    public function __toString()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->registrations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->administrators = new \Doctrine\Common\Collections\ArrayCollection();
        $this->participants_types = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Convention
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
     * Set description
     *
     * @param string $description
     *
     * @return Convention
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
     * Set site code
     *
     * @param string $slug
     *
     * @return Convention
     */
    public function setSlug($slug)
    {
        $this->slug = strtolower($slug);

        return $this;
    }

    /**
     * Get site code
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set web
     *
     * @param string $web
     *
     * @return Convention
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Convention
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     *
     * @return Convention
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Convention
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set startsAt
     *
     * @param \DateTime $startsAt
     *
     * @return Convention
     */
    public function setStartsAt($startsAt)
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * Get startsAt
     *
     * @return \DateTime
     */
    public function getStartsAt()
    {
        return $this->startsAt;
    }

    /**
     * Set endsAt
     *
     * @param \DateTime $endsAt
     *
     * @return Convention
     */
    public function setEndsAt($endsAt)
    {
        $this->endsAt = $endsAt;

        return $this;
    }

    /**
     * Get endsAt
     *
     * @return \DateTime
     */
    public function getEndsAt()
    {
        return $this->endsAt;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Convention
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set maintenance
     *
     * @param boolean $maintenance
     *
     * @return Convention
     */
    public function setMaintenance($maintenance)
    {
        $this->maintenance = $maintenance;

        return $this;
    }

    /**
     * Get maintenance
     *
     * @return boolean
     */
    public function getMaintenance()
    {
        return $this->maintenance;
    }

    /**
     * Add registration
     *
     * @param \AppBundle\Entity\Registration $registration
     *
     * @return Convention
     */
    public function addRegistration(\AppBundle\Entity\Registration $registration)
    {
        $this->registrations[] = $registration;

        return $this;
    }

    /**
     * Remove registration
     *
     * @param \AppBundle\Entity\Registration $registration
     */
    public function removeRegistration(\AppBundle\Entity\Registration $registration)
    {
        $this->registrations->removeElement($registration);
    }

    /**
     * Get registrations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * Add administrator
     *
     * @param \AppBundle\Entity\User $administrator
     *
     * @return Convention
     */
    public function addAdministrator(\AppBundle\Entity\User $administrator)
    {
        $this->administrators[] = $administrator;

        return $this;
    }

    /**
     * Remove administrator
     *
     * @param \AppBundle\Entity\User $administrator
     */
    public function removeAdministrator(\AppBundle\Entity\User $administrator)
    {
        $this->administrators->removeElement($administrator);
    }

    /**
     * Get administrators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdministrators()
    {
        return $this->administrators;
    }

    /**
     * @return string
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * @param string $twitter
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;
    }

    /**
     * @return string
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param string $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }

    /**
     * @return string
     */
    public function getInstagram()
    {
        return $this->instagram;
    }

    /**
     * @param string $instagram
     */
    public function setInstagram($instagram)
    {
        $this->instagram = $instagram;
    }



    /**
     * Add participantsType
     *
     * @param \AppBundle\Entity\ParticipantType $participantsType
     *
     * @return Convention
     */
    public function addParticipantsType(\AppBundle\Entity\ParticipantType $participantsType)
    {
        $this->participants_types[] = $participantsType;

        return $this;
    }

    /**
     * Remove participantsType
     *
     * @param \AppBundle\Entity\ParticipantType $participantsType
     */
    public function removeParticipantsType(\AppBundle\Entity\ParticipantType $participantsType)
    {
        $this->participants_types->removeElement($participantsType);
    }

    /**
     * Get participantsTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParticipantsTypes()
    {
        return $this->participants_types;
    }
}
