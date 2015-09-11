<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/08/15
 * Time: 01:33
 */

namespace AppBundle\Security\Voter;


use AppBundle\Security\Core\Role\OrganizerRole;
use AppBundle\Site\SiteManager;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchy;

abstract class AbstractOrganizationVoter implements VoterInterface
{
    /**
     * @var SiteManager
     */
    protected $siteManager;
    /**
     * @var RoleHierarchy
     */
    private $roleHierarchy;

    /**
     * Construct
     *
     * @param SiteManager $siteManager
     */
    function __construct(SiteManager $siteManager, RoleHierarchy $roleHierarchy)
    {
        $this->siteManager = $siteManager;
        $this->roleHierarchy = $roleHierarchy;
    }

    /**
     * Checks if the voter supports the given attribute.
     *
     * @param string $attribute An attribute
     *
     * @return bool true if this Voter supports the attribute, false otherwise
     */
    public function supportsAttribute($attribute)
    {
        $entity = strtoupper(join('', array_slice(explode('\\', $this->getClass()), -1)));
        $code = $this->siteManager->getCurrentSite()->getCode();
        return preg_match("/ROLE_{$code}_RITSIGA_ADMIN_{$entity}_[CREATE|DELETE|EDIT|VIEW]/", $attribute) === 1 ? true : false;
    }

    /**
     * Checks if the voter supports the given class.
     *
     * @param string $class A class name
     *
     * @return bool true if this Voter can process the class
     */
    public function supportsClass($class)
    {
        if ($this->getClass() === $class || is_subclass_of($class, $this->getClass())) {
            return true;
        }
        return false;
    }


    /**
     * Returns the vote for the given parameters.
     *
     * This method must return one of the following constants:
     * ACCESS_GRANTED, ACCESS_DENIED, or ACCESS_ABSTAIN.
     *
     * @param TokenInterface $token A TokenInterface instance
     * @param object|null $object The object to secure
     * @param array $attributes An array of attributes associated with the method being invoked
     *
     * @return int either ACCESS_GRANTED, ACCESS_ABSTAIN, or ACCESS_DENIED
     */
    public function vote(TokenInterface$token, $object, array $attributes)
    {
        if ($token->getUser() instanceof UserInterface === false) {
            return self::ACCESS_ABSTAIN;
        }

        if (!$object || !$this->supportsClass(get_class($object))) {
            return self::ACCESS_ABSTAIN;
        }

        // abstain vote by default in case none of the attributes are supported
        $vote = self::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            // as soon as at least one attribute is supported, default is to deny access
            $vote = self::ACCESS_DENIED;

            if ($token->getUser()->hasRole('ROLE_ADMIN')) {
                return self::ACCESS_ABSTAIN;
            }

            foreach($token->getUser()->getRoles() as $role) {
                $roleHierarchy = $this->roleHierarchy->getReachableRoles([new Role($role)]);
                foreach($roleHierarchy as $node) {
                    if ($node->getRole() == $attribute) {
                        return self::ACCESS_GRANTED;
                    }
                }
            }
        }

        return $vote;
    }

    abstract function getClass();
}