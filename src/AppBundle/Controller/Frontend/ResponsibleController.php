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
use AppBundle\Form\Type\ResponsibleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}/responsible")
 * @Security("is_granted('ROLE_USER')")
 */
class ResponsibleController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="responsible_edit")
     */
    public function editAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ResponsibleType(), $registration);

        return $this->render(':frontend/responsible:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/", methods={"POST"}, name="responsible_update")
     */
    public function updateAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new ResponsibleType(), $registration);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();
            $this->addFlash('success', 'success.registration');

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/responsible:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
