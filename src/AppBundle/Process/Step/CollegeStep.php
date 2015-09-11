<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 2/05/15
 * Time: 10:01
 */

namespace AppBundle\Process\Step;


use AppBundle\Form\CollegeType;
use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;

class CollegeStep extends BaseStep
{
    public function displayAction(ProcessContextInterface $context)
    {
        $user = $this->getUser();
        $college = $user->getStudentDelegation()->getCollege();
        $form = $this->createForm(new CollegeType(), $college);

        return $this->render(':frontend/registration/process:college.html.twig', array(
            'form' => $form->createView(),
            'context' => $context
        ));
    }

    public function forwardAction(ProcessContextInterface $context)
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        $user = $this->getUser();
        $college=$user->getStudentDelegation()->getCollege();

        $form = $this->createForm(new CollegeType(), $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($college);
            $em->flush();
            $this->addFlash('warning', $this->get('translator')->trans( 'Your college has been successfully updated'));

            return $this->complete();
        }

        return $this->render(':frontend/registration/process:college.html.twig', array(
            'form' => $form->createView(),
            'context' => $context
        ));
    }


}