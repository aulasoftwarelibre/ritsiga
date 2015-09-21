<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 12/09/15
 * Time: 19:59.
 */
namespace AppBundle\Security\Voter;

use AppBundle\Doctrine\ORM\ConventionRepository;
use AppBundle\Entity\Ticket;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

class AvailableSeatsVoter extends AbstractVoter
{
    /**
     * @var ConventionRepository
     */
    private $repository;

    /**
     * AvailableSeatsVoter constructor.
     *
     * @param ConventionRepository $repository
     */
    public function __construct(ConventionRepository $repository)
    {
        $this->repository = $repository;
    }

    protected function getSupportedClasses()
    {
        return [
            'AppBundle\Entity\Ticket',
        ];
    }

    protected function getSupportedAttributes()
    {
        return [
            'REGISTRATION_OPEN',
            'SEATS_AVAILABLE',
        ];
    }

    /**
     * @param string          $attribute
     * @param Ticket $object
     * @param null            $user
     *
     * @return bool
     */
    protected function isGranted($attribute, $object, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($attribute === 'REGISTRATION_OPEN') {
            if ($object->isPublic() === false) {
                return false;
            }

            $now = new \DateTime('today');
            if ($now < $object->getStartDate() || $now > $object->getEndDate()) {
                return false;
            }

            return true;
        }

        $convention = $object->getConvention();
        $seats = $this->repository->countSeats($convention, $user);

        if ($object->isReduced()) {
            if ($seats < $convention->getReducedSeats()) {
                return true;
            }
        } else {
            if ($seats < $convention->getSeats()) {
                return true;
            }
        }

        return false;
    }
}
