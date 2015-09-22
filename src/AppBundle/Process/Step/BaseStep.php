<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 11/09/15
 * Time: 19:10.
 */
namespace AppBundle\Process\Step;

use AppBundle\Entity\Registration;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

abstract class BaseStep extends ControllerStep
{
    public function getCurrentSite()
    {
        return $this->container->get('ritsiga.site.manager')->getCurrentSite();
    }

    /**
     * @return Registration
     */
    public function getCurrentRegistration()
    {
        $user = $this->getUser();
        $registration = $this->container->get('ritsiga.repository.registration')->findOneBy(['user' => $user]);

        if (!$registration) {
            $this->createNotFoundException();
        }

        return $registration;
    }
}
