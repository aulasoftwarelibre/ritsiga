<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 15/07/15
 * Time: 18:53.
 */
namespace AppBundle\Controller\Frontend;

use AppBundle\Controller\Controller;
use AppBundle\Entity\Registration;
use AppBundle\Event\RegistrationEvent;
use AppBundle\Event\RegistrationEvents;
use AppBundle\Form\TravelInformationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegistrationController.
 *
 * @Route(path="/convention/{slug}")
 */
class RegistrationController extends Controller
{
    private function setRegistrationStatus(Registration $registration, $status)
    {
        $registration->setStatus($status);
        $em = $this->getDoctrine()->getManager();
        $em->persist($registration);
        $em->flush();
    }

    /**
     * @Route("/inscripciones", name="registration_list")
     * @Template("frontend/registration/my_registrations.html.twig")
     * @Security("is_granted('ROLE_USER')")
     * Muestra todas las inscripciones del usuario
     */
    public function showRegistrations()
    {
        $registrations_open = $this->get('ritsiga.repository.registration')->findBy([
            'status' => Registration::STATUS_CONFIRMED,
            'user' => $this->getUser(),
        ]);
        $registrations_paid = $this->get('ritsiga.repository.registration')->findBy([
            'status' => Registration::STATUS_PAID,
            'user' => $this->getUser(),
        ]);

        return $this->render('frontend/registration/my_registrations.html.twig', [
            'registrations_open' => $registrations_open,
            'registrations_paid' => $registrations_paid,
        ]);
    }

    /**
     * @Route("/confirmar_registro", name="registration_confirmed")
     * Manda el evento para confirmar el registro
     */
    public function confirmedRegistrationAction(Request $request)
    {
        $registration = $this->getRegistration();
        if ($registration->getStatus() == Registration::STATUS_OPEN && $registration->getParticipants()->isEmpty() == false) {
            $this->setRegistrationStatus($registration, Registration::STATUS_CONFIRMED);
            $this->container->get('event_dispatcher')->dispatch(RegistrationEvents::CONFIRMED, new RegistrationEvent($registration));
        }

        return $this->redirectToRoute('registration');
    }

    /**
     * @Route("/abrir_registro", name="registration_open")
     * Manda el evento para abrir el registro
     */
    public function openRegistrationAction(Request $request)
    {
        $registration = $this->getRegistration();
        if ($registration->getStatus() == Registration::STATUS_CONFIRMED) {
            $this->setRegistrationStatus($registration, Registration::STATUS_OPEN);
            $this->container->get('event_dispatcher')->dispatch(RegistrationEvents::OPEN, new RegistrationEvent($registration));
        }

        return $this->redirectToRoute('registration');
    }

    /**
     * @Route("/registro", name="registration")
     * Muestra pantalla de edición del registro
     */
    public function registrationAction(Request $request)
    {
        $registration = $this->getRegistration();
        $convention = $this->getConvention();

        if (!$registration || $registration->getStatus() == Registration::STATUS_INIT) {
            return $this->redirectToRoute('sylius_flow_start', array('scenarioAlias' => 'asamblea'));
        }

        if ($registration->getStatus() == Registration::STATUS_OPEN) {
            $tickets = $this->getDoctrine()->getRepository('AppBundle:Ticket')->findTicketsAvailability($convention);

            return $this->render(':frontend/registration/status:registration_open.html.twig', array(
                'registration' => $registration,
                'tickets' => $tickets,
            ));
        }

        if ($registration->getStatus() == Registration::STATUS_CONFIRMED) {
            return $this->render(':frontend/registration/status:registration_confirmed.html.twig', array(
                'registration' => $registration,
                'entity_bank' => $this->container->getParameter('entity_bank'),
                'organization' => $this->container->getParameter('organization'),
                'iban' => $this->container->getParameter('iban'),
            ));
        }

        if ($registration->getStatus() == Registration::STATUS_CANCELLED) {
            return $this->render(':frontend/registration/status:registration_cancelled.html.twig', array(
                'registration' => $registration,
            ));
        }

        if ($registration->getStatus() == Registration::STATUS_PAID) {
            $this->addFlash('info', $this->get('translator')->trans('El registro se encuentra pagado y confirmado'));

            return $this->render(':frontend/registration/status:registration_paid.html.twig', array(
                'registration' => $registration,
                'entity_bank' => $this->container->getParameter('entity_bank'),
                'organization' => $this->container->getParameter('organization'),
                'iban' => $this->container->getParameter('iban'),
            ));
        }
    }

    /**
     * @Route("/descargar_factura", name="invoice_draft_download")
     */
    public function downloadInvoiceAction()
    {
        $registration = $this->getRegistration();

        if (!$this->getConvention()->isPublishedDraft()) {
            throw $this->createNotFoundException();
        }

        if (!in_array($registration->getStatus(), [Registration::STATUS_PAID, Registration::STATUS_CONFIRMED])) {
            throw $this->createNotFoundException();
        }

        return new Response(
            $this->get('ritsiga.business.document_generator')->generateInvoiceDraft($registration, $filename),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            )
        );
    }

    /**
     * @Route("/informar_viaje", name="travel_information")
     * Muestra formulario para la información del viaje
     */
    public function travelInformationAction(Request $request)
    {
        $registration = $this->getRegistration();
        if ($registration->getStatus() == Registration::STATUS_OPEN) {
            return $this->redirectToRoute('registration');
        }
        $form = $this->createForm(new TravelInformationType(), $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($registration);
            $em->flush();
            $this->addFlash('info', $this->get('translator')->trans('Your travel information has been successfully updated'));

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/registration:travel_information.html.twig', array(
            'registration' => $registration,
            'form' => $form->createView(),
        ));
    }
}
