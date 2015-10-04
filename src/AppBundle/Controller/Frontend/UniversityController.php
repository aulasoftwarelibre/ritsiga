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
use AppBundle\Form\Type\UniversityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}/university")
 * @Security("is_granted('ROLE_USER')")
 */
class UniversityController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="university_edit")
     */
    public function editAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $university = $user->getUniversity();

        $form = $this->createForm(new UniversityType(), $university);

        return $this->render(':frontend/university:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/", methods={"POST"}, name="university_update")
     */
    public function updateAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $university = $user->getUniversity();

        $form = $this->createForm(new UniversityType(), $university);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($university);
            $em->flush();
            $this->addFlash('success', 'success.university');

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/university:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
