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
use AppBundle\Form\Type\CollegeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}/college")
 * @Security("is_granted('ROLE_USER')")
 */
class CollegeController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="college_edit")
     */
    public function editAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $college = $user->getCollege();

        $form = $this->createForm(new CollegeType(), $college);

        return $this->render(':frontend/college:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/", methods={"POST"}, name="college_update")
     */
    public function updateAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $user = $this->getUser();
        $college = $user->getCollege();

        $form = $this->createForm(new CollegeType(), $college);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($college);
            $em->flush();
            $this->addFlash('success', 'success.college');

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/college:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
