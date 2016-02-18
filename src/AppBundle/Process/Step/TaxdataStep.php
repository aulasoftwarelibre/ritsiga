<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/09/15
 * Time: 18:58.
 */
namespace AppBundle\Process\Step;

use AppBundle\Entity\Registration;
use AppBundle\Form\Type\TaxDataType;
use FOS\RestBundle\View\View;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Sylius\Bundle\FlowBundle\Process\Step\ActionResult;
use Symfony\Component\HttpFoundation\Response;

class TaxdataStep extends BaseStep
{
    /**
     * Display action.
     *
     * @param ProcessContextInterface $context
     *
     * @return ActionResult|Response|View
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $registration = $this->getCurrentRegistration();
        $taxdata = $registration->getTaxdata();
        $form = $this->createForm(new TaxDataType(), $taxdata);

        return $this->render('frontend/registration/process/taxdata.html.twig', [
            'form' => $form->createView(),
            'context' => $context,
        ]);
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();

        $registration = $this->getCurrentRegistration();
        $taxdata = $registration->getTaxdata();

        $form = $this->createForm(new TaxDataType(), $taxdata);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $registration->setStatus(Registration::STATUS_OPEN);

            $em = $this->getDoctrine()->getManager();
            $em->persist($taxdata);
            $em->flush();

            $this->addFlash('success', 'success.taxdata');

            return $this->complete();
        }

        return $this->render('frontend/registration/process/taxdata.html.twig', [
            'form' => $form->createView(),
            'context' => $context,
        ]);
    }
}
