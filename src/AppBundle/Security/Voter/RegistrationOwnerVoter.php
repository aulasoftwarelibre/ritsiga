<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 13/09/15
 * Time: 08:12.
 */
namespace AppBundle\Security\Voter;

use AppBundle\Entity\Registration;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationOwnerVoter extends AbstractVoter
{
    /**
     * Return an array of supported classes. This will be called by supportsClass.
     *
     * @return array an array of supported classes, i.e. array('Acme\DemoBundle\Model\Product')
     */
    protected function getSupportedClasses()
    {
        return [
            'AppBundle\Entity\Registration',
        ];
    }

    /**
     * Return an array of supported attributes. This will be called by supportsAttribute.
     *
     * @return array an array of supported attributes, i.e. array('CREATE', 'READ')
     */
    protected function getSupportedAttributes()
    {
        return [
            'REGISTRATION_OWNER',
        ];
    }

    /**
     * Perform a single access check operation on a given attribute, object and (optionally) user
     * It is safe to assume that $attribute and $object's class pass supportsAttribute/supportsClass
     * $user can be one of the following:
     *   a UserInterface object (fully authenticated user)
     *   a string               (anonymously authenticated user).
     *
     * @param string               $attribute
     * @param Registration         $object
     * @param UserInterface|string $user
     *
     * @return bool
     */
    protected function isGranted($attribute, $object, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        return $user == $object->getUser();
    }
}
