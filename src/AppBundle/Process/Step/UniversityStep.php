<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 22/04/15
 * Time: 11:29.
 */
namespace AppBundle\Process\Step;

use AppBundle\Form\UniversityType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class UniversityStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $user = $this->getUser();
        $university = $user->getUniversity();
        $form = $this->createForm(new UniversityType(), $university);

        return $this->render(':frontend/registration/process:university.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $user = $this->getUser();
        $university = $user->getUniversity();

        $form = $this->createForm(new UniversityType(), $university);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($university);
            $em->flush();
            $this->addFlash('warning', $this->get('translator')->trans('Your university has been successfully updated'));

            return $this->complete();
        }

        return $this->render(':frontend/registration/process:university.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }
}
