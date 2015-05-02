<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/04/15
 * Time: 21:09
 */

namespace AppBundle\Doctrine\ORM;
use Doctrine\ORM\EntityRepository;

class UniversityRepository extends EntityRepository
{
    public function findUniversity($word)
    {
        $em=$this->getEntityManager();
        $query=$em->createQuery('
        SELECT o
        FROM AppBundle:University o
        WHERE o.name LIKE :word');

        $query->setParameter('word','%'.$word.'%');
        return $query->getResult();
    }
}