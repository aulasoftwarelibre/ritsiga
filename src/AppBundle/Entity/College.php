<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 22/04/15
 * Time: 12:45.
 */
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * College.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\CollegeRepository")
 */
class College
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
     * @var University
     * @ORM\JoinColumn(
     *     nullable=false,
     *     onDelete="CASCADE",
     * )
     * @ORM\ManyToOne(targetEntity="\AppBundle\Entity\University", inversedBy="colleges")
     */
    private $university;
    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\AcademicDegree", inversedBy="colleges")
     * @Assert\Count(min="1", minMessage="error.select_degree")
     */
    private $academic_degrees;
    /**
     * @var string
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\StudentDelegation", mappedBy="college")
     */
    private $students_delegations;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->academic_degrees = new ArrayCollection();
        $this->students_delegations = new ArrayCollection();
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
     * Set university.
     *
     * @param \AppBundle\Entity\University $university
     *
     * @return College
     */
    public function setUniversity(\AppBundle\Entity\University $university = null)
    {
        $this->university = $university;

        return $this;
    }

    /**
     * Get university.
     *
     * @return \AppBundle\Entity\University
     */
    public function getUniversity()
    {
        return $this->university;
    }

    /**
     * Add academicDegree.
     *
     * @param \AppBundle\Entity\AcademicDegree $academicDegree
     *
     * @return College
     */
    public function addAcademicDegree(\AppBundle\Entity\AcademicDegree $academicDegree)
    {
        $this->academic_degrees[] = $academicDegree;

        return $this;
    }

    /**
     * Remove academicDegree.
     *
     * @param \AppBundle\Entity\AcademicDegree $academicDegree
     */
    public function removeAcademicDegree(\AppBundle\Entity\AcademicDegree $academicDegree)
    {
        $this->academic_degrees->removeElement($academicDegree);
    }

    /**
     * Get academicDegrees.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAcademicDegrees()
    {
        return $this->academic_degrees;
    }

    /**
     * Add studentsDelegation.
     *
     * @param \AppBundle\Entity\College $studentsDelegation
     *
     * @return College
     */
    public function addStudentsDelegation(\AppBundle\Entity\StudentDelegation $studentsDelegation)
    {
        $this->students_delegations[] = $studentsDelegation;

        return $this;
    }

    /**
     * Remove studentsDelegation.
     *
     * @param \AppBundle\Entity\College $studentsDelegation
     */
    public function removeStudentsDelegation(\AppBundle\Entity\StudentDelegation $studentsDelegation)
    {
        $this->students_delegations->removeElement($studentsDelegation);
    }

    /**
     * Get studentsDelegations.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentsDelegations()
    {
        return $this->students_delegations;
    }

    /**
     * Get college name.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }
}
