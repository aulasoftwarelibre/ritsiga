<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 09/09/15
 * Time: 05:17
 */

namespace AppBundle\Security\Core\Role;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Role\RoleHierarchy as BaseRoleHierarchy;

class RoleHierarchy extends BaseRoleHierarchy
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(array $hierarchy, EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct($this->buildRolesTree($hierarchy));
    }

    protected function buildRolesTree($hierarchy)
    {
        $conventions = $this->em->getRepository('AppBundle:Convention')->findAll();
        $baseRoles = $hierarchy['ROLE_RITSIGA_ORGANIZER_CONVENTION'];

        foreach($conventions as $convention) {
            $roles = [];
            $code = $convention->getSlug();
            foreach ($baseRoles as $role) {
                $roles[] = preg_replace('/RITSI/', $code, $role, 1);
            }
            $hierarchy["ROLE_RITSIGA_ORGANIZER_{$code}"] = $roles;
        }

        return $hierarchy;
    }
}