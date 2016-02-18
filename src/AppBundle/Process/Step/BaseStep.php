<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 11/09/15
 * Time: 19:10.
 */
namespace AppBundle\Process\Step;

use AppBundle\Entity\Registration;
use AppBundle\Entity\TaxData;
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
        $convention = $this->getCurrentSite();
        $registration = $this->get('ritsiga.repository.registration')->findOneBy(array(
            'user' => $user,
            'convention' => $convention,
        ));

        if (!$registration) {
            $convention = $this->getCurrentSite();
            $registration = new Registration();
            $registration->setConvention($convention);
            $registration->setUser($user);
            $registration->setTaxdata(TaxData::copyFromUniversity($this->getUser()->getUniversity()));
        }

        return $registration;
    }

    protected function addFlash($type, $message)
    {
        $message = $this->get('translator')->trans($message, [], 'flashes');
        parent::addFlash($type, $message);
    }
}
