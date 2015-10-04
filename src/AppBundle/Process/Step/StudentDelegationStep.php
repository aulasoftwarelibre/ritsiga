<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/06/15
 * Time: 12:39.
 */
namespace AppBundle\Process\Step;

use AppBundle\Form\Type\StudentDelegationType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class StudentDelegationStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $user = $this->getUser();
        $student = $user->getStudentDelegation();
        $form = $this->createForm(new StudentDelegationType(), $student);

        return $this->render(':frontend/registration/process:student_delegation.html.twig', array(
            'form' => $form->createView(),
            'user' => $user,
            'context' => $context,
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $user = $this->getUser();
        $student = $user->getStudentDelegation();

        $form = $this->createForm(new StudentDelegationType(), $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
            $this->addFlash('success', 'success.student_delegation');

            return $this->complete();
        }

        return $this->render(':frontend/registration/process:student_delegation.html.twig', array(
            'form' => $form->createView(),
            'context' => $context,
        ));
    }
}
