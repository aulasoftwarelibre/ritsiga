<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/07/15
 * Time: 18:05.
 */
namespace AppBundle\Security\Voter\Sonata;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ConventionVoter extends AbstractOrganizationVoter
{
    public function getClass()
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
