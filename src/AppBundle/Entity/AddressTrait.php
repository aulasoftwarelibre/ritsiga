<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/09/15
 * Time: 18:22
 */

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

trait AddressTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="255")
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="address", type="text")
     * @Assert\NotBlank()
     */
    private $address;
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="100")
     */
    private $city;
    /**
     * @var string
     *
     * @ORM\Column(name="province", type="string", length=100)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="100")
     */
    private $province;
    /**
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="10")
     *
     */
    private $postcode;
    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=100, nullable=true)
     * @Assert\Length(max=100)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=100, nullable=true)
     * @Assert\Length(max=100)
     */
    private $fax;
    /**
     * @var string
     *
     * @ORM\Column(name="web", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $web;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     * @Assert\Length(max=100)
     */
    private $email;
    /**
     * @var string
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     * @Assert\Length(max=100)
     */
    private $twitter;
    /**
     * @var string
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     * @Assert\Length(max=100)
     */
    private $facebook;
    /**
     * @var string
     *
     * @ORM\Column(name="cif", type="string", length=100, nullable=true)
     * @Assert\NotBlank(groups={"taxdata"})
     * @Assert\Length(min=3, max=100)
     */
    private $cif;
    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=100)
     * @Gedmo\Slug(fields={"name"}, unique=true)
     */
    private $slug;

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
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param string $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
    }

    /**
     * @return int
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param int $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
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
     * @return int
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param int $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    /**
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @param string $web
     */
    public function setWeb($web)
    {
        $this->web = $web;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * @param string $cif
     */
    public function setCif($cif)
    {
        $this->cif = $cif;
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
}