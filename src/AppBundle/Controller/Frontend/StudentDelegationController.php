<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 4/10/15
 * Time: 0:45.
 */
namespace AppBundle\Controller\Frontend;

use AppBundle\Controller\Controller;
use AppBundle\Entity\Registration;
use AppBundle\Form\Type\StudentDelegationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}/student_delegation")
 * @Security("is_granted('ROLE_USER')")
 */
class StudentDelegationController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="student_delegation_edit")
     */
    public function editAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $student_delegation = $user->getStudentDelegation();

        $form = $this->createForm(new StudentDelegationType(), $student_delegation);

        return $this->render(':frontend/student_delegation:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/", methods={"POST"}, name="student_delegation_update")
     */
    public function updateAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $student_delegation = $user->getStudentDelegation();

        $form = $this->createForm(new StudentDelegationType(), $student_delegation);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student_delegation);
            $em->flush();
            $this->addFlash('success', 'success.student_delegation');

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/student_delegation:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
