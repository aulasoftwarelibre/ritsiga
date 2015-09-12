<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/08/15
 * Time: 23:58.
 */
namespace AppBundle\Security\Core\Role;

use AppBundle\Entity\Convention;
use Symfony\Component\Security\Core\Role\RoleInterface;

class OrganizerRole implements RoleInterface
{
    /**
     * @var Convention
     */
    private $role;

    /**
     * @var string
     */
    private $code;

    /**
     * OrganizerRole constructor.
     *
     * @param Convention $convention
     */
    public function __construct(Convention $convention)
    {
        $this->role = 'ROLE_RITSIGA_ORGANIZER_'.$convention->getSlug();
        $this->code = $convention->getSlug();
    }

    /**
     * Returns the role.
     *
     * This method returns a string representation whenever possible.
     *
     * When the role cannot be represented with sufficient precision by a
     * string, it should return null.
     *
     * @return string|null A string representation of the role, or null
     */
    public function getRole()
    {
        return $this->role;
    }

    public function getRoles($object, $attributes)
    {
        $roles = [];
        foreach ($attributes as $attribute) {
            $roles[] = sprintf('ROLE_%s_RITSIGA_ADMIN_%s_%s', $this->code, $object, $attribute);
        }

        return $roles;
    }
}
