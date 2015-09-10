<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/07/15
 * Time: 18:05
 */

namespace AppBundle\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ConventionVoter extends AbstractOrganizationVoter
{
    function getClass()
    {
        return 'AppBundle\Entity\Convention';
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $vote = parent::vote($token, $object, $attributes);

        if ($vote === self::ACCESS_GRANTED && $this->siteManager->getCurrentSite() != $object) {
            $vote = self::ACCESS_DENIED;
        }

        return $vote;
    }
}