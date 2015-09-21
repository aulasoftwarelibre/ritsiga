<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 22/04/15
 * Time: 12:43.
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * University.
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class University
{
    use AddressTrait;
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
     * @ORM\Column(name="type",  type="string", length=100)
     */
    private $type;
    /**
     * @var string
     * @ORM\OneToMany(targetEntity="College", mappedBy="university")
     */
    private $colleges;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->colleges = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set slug.
     *
     * @param string $slug
     *
     * @return University
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add college.
     *
     * @param \AppBundle\Entity\College $college
     *
     * @return University
     */
    public function addCollege(\AppBundle\Entity\College $college)
    {
        $this->colleges[] = $college;

        return $this;
    }

    /**
     * Remove college.
     *
     * @param \AppBundle\Entity\College $college
     */
    public function removeCollege(\AppBundle\Entity\College $college)
    {
        $this->colleges->removeElement($college);
    }

    /**
     * Get colleges.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getColleges()
    {
        return $this->colleges;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return University
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return entity name.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }
}
