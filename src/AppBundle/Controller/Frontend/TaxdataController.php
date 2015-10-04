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
use AppBundle\Form\Type\TaxDataType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}/taxdata")
 * @Security("is_granted('ROLE_USER')")
 */
class TaxdataController extends Controller
{
    /**
     * @Route(path="/", methods={"GET"}, name="taxdata_edit")
     */
    public function editAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new TaxDataType(), $registration->getTaxdata());

        return $this->render(':frontend/taxdata:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route(path="/", methods={"POST"}, name="taxdata_update")
     */
    public function updateAction(Request $request)
    {
        $registration = $this->getRegistration();

        if (!$registration || $registration->getStatus() != Registration::STATUS_OPEN) {
            throw $this->createNotFoundException();
        }

        $taxdata = $registration->getTaxdata();
        $form = $this->createForm(new TaxdataType(), $taxdata);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($taxdata);
            $em->flush();
            $this->addFlash('success', 'success.taxdata');

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/taxdata:edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
