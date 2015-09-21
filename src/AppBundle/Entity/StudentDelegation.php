<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 22/04/15
 * Time: 17:24.
 */
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Student Delegation.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\StudentDelegationRepository")
 */
class StudentDelegation
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
     * @var College
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\College", inversedBy="students_delegations")
     */
    private $college;

    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="User",mappedBy="student_delegation")
     */
    private $users;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get student delegation name.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Set college.
     *
     * @param \AppBundle\Entity\College $college
     *
     * @return StudentDelegation
     */
    public function setCollege(\AppBundle\Entity\College $college = null)
    {
        $this->college = $college;

        return $this;
    }

    /**
     * Get college.
     *
     * @return \AppBundle\Entity\College
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return StudentDelegation
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}
