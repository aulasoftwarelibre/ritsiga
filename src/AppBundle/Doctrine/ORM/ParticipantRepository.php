<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 23/07/15
 * Time: 20:44.
 */
namespace AppBundle\Doctrine\ORM;

use AppBundle\Entity\ParticipantType;
use AppBundle\Entity\Registration;
use Doctrine\ORM\EntityRepository;

class ParticipantRepository extends EntityRepository
{
    public function getNumParticipationsTypesAvailables(Registration $registration, ParticipantType $participantType)
    {
        $em = $this->getEntityManager();
        $consulta = $em->createQuery('
                SELECT count(o.id)
                FROM AppBundle:Participant o
                WHERE :participant_type = o.participant_type
                AND o.registration = :registration
            ')->setParameter('participant_type', $participantType)
            ->setParameter('registration', $registration);

        return $consulta->getSingleScalarResult();
    }

    /**
     * Función que busca si un DNI se ha utilizado ya en una asamblea para dar de alta a un asistente
     * Recibe como parámetros el dni y el id del registro.
     *
     * @param array $params
     *
     * @return array
     */
    public function findUniqueParticipant(array $params)
    {
        /** @var Registration $registration */
        $registration = $this->getEntityManager()->getRepository('AppBundle:Registration')->find($params['registration']);
        $dni = $params['dni'];

        $qb = $this->createQueryBuilder('participant');
        $query = $qb->leftJoin('participant.registration', 'registration')
            ->where('participant.dni = :dni')
            ->andWhere('registration.convention = :convention')
            ->setParameter('dni', $dni)
            ->setParameter('convention', $registration->getConvention())
            ->getQuery()
        ;

        return $query->getResult();
    }
}
