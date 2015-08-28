<?php

namespace AppBundle\Doctrine\ORM;

use AppBundle\Entity\Convention;
use Doctrine\ORM\EntityRepository;

/**
 * ConventionRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConventionRepository extends EntityRepository
{
    public function findConventionsAvailables() {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
            SELECT o
            FROM AppBundle:Convention o
            WHERE :today < o.endsAt
            AND o.maintenance = FALSE
            ORDER BY o.endsAt DESC
        ')->setParameter('today', new \DateTime());

        return $consulta->getResult();
    }

    public function getQueryConvention(Convention $convention)
    {
        $qb = $this->createQueryBuilder('convention');

        return $qb->where('convention.id=:id')
            ->setParameter('id', $convention->getId());
    }
}
