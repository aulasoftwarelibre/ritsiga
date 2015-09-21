<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/06/15
 * Time: 13:40.
 */
namespace AppBundle\Process\Step;

use AppBundle\Entity\Registration;
use AppBundle\Entity\TaxData;
use AppBundle\Form\ResponsibleType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class ResponsibleStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $convention = $this->getCurrentSite();
        $registration = new Registration();
        $registration->setConvention($convention);
        $taxdata = TaxData::copyFromUniversity($this->getUser()->getUniversity());
        $registration->setTaxdata($taxdata);
        $form = $this->createForm(new ResponsibleType(), $registration);


        return $this->render(':frontend/registration/process:responsible.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $convention = $this->getCurrentSite();
        $registration = new Registration();
        $registration->setConvention($convention);
        $taxdata = TaxData::copyFromUniversity($this->getUser()->getUniversity());
        $registration->setTaxdata($taxdata);
        $form = $this->createForm(new ResponsibleType(), $registration);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $registration->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();
            $this->addFlash('warning', $this->get('translator')->trans('Your registration has been saved, you can now add registrations'));

            return $this->complete();
        }

        return $this->render(':frontend/registration/process:responsible.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }
}
