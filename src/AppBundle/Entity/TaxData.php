<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/09/15
 * Time: 18:12
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class TaxData
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Doctrine\ORM\TaxDataRepository")
 * @ORM\Table()
 */
class TaxData
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
     * @var Registration
     *
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Registration", inversedBy="taxdata")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $registration;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Registration
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @param Registration $registration
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;
    }

    /**
     * Exports tax data from one university.
     *
     * @param University $university
     * @return TaxData
     */
    public static function copyFromUniversity(University $university)
    {
        $taxdata = new TaxData();
        $taxdata->setName($university->getName());
        $taxdata->setAddress($university->getAddress());
        $taxdata->setCity($university->getCity());
        $taxdata->setProvince($university->getProvince());
        $taxdata->setPostcode($university->getPostcode());
        $taxdata->setCif($university->getCif());

        return $taxdata;
    }

    /**
     * Get organization name.
     *
     * @return string
     */
    function __toString()
    {
        return $this->getName();
    }


}