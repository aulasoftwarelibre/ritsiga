<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/06/15
 * Time: 13:40.
 */
namespace AppBundle\Process\Step;

use AppBundle\Form\Type\ResponsibleType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class ResponsibleStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $registration = $this->getCurrentRegistration();

        $form = $this->createForm(new ResponsibleType(), $registration);

        return $this->render(':frontend/registration/process:responsible.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $registration = $this->getCurrentRegistration();

        $form = $this->createForm(new ResponsibleType(), $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();
            $this->addFlash('success', 'success.registration');

            return $this->complete();
        }

        return $this->render(':frontend/registration/process:responsible.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }
}
