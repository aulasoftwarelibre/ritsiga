<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 2/05/15
 * Time: 12:05
 */

namespace AppBundle\Process\Step;

use AppBundle\Entity\Participant;
use AppBundle\Entity\Registration;
use AppBundle\Form\RegistrationType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

class ResponsibleStep extends ControllerStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $request = $context->getRequest();
        $siteManager = $this->container->get('ritsiga.site.manager');
        $convention = $siteManager->getCurrentSite();
        $participant = new Participant();
        $participant->setType('invitado');


        $registration= new Registration();
        $registration->setConvention($convention);
        $registration->setUser($user);
        $registration->getParticipants()->add($participant);
        $form = $this->createForm(new RegistrationType(), $registration);


        return $this->render(':Registration:responsible.html.twig', array(
            'convention' => $convention,
            'form' => $form->createView(),
            'user' => $user,
            'context' => $context
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        return $this->complete();
    }


}