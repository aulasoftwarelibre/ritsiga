<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 22/04/15
 * Time: 11:29.
 */
namespace AppBundle\Process\Step;

use AppBundle\Entity\Registration;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class WelcomeStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $user = $this->getUser();
        $convention = $this->getCurrentSite();
        /** @var Registration $registration */
        $registration = $this->get('ritsiga.repository.registration')->findOneBy(array(
            'user' => $user,
            'convention' => $convention,
        ));

        if (!$user->getStudentDelegation()) {
            $this->addFlash('warning', 'warning.complete_data');

            return $this->redirectToRoute('fos_user_profile_edit');
        }

        if ($registration && $registration->getStatus() != Registration::STATUS_INIT) {
            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/registration/process:welcome.html.twig', array(
            'context' => $context,
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        return $this->complete();
    }
}
