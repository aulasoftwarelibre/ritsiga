<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 23/08/15
 * Time: 20:26.
 */
namespace AppBundle\Controller\Frontend;

use AppBundle\Controller\Controller;
use AppBundle\Entity\Participant;
use AppBundle\Entity\Ticket;
use AppBundle\Entity\Registration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ParticipantController.
 *
 * @Route(path="/convention/{slug}/inscription")
 */
class ParticipantController extends Controller
{
    /**
     * @Route("/new/{ticket}/ticket", name="participant_new")
     * Muestra pantalla de nueva inscripción
     */
    public function newParticipantAction(Request $request, Ticket $ticket)
    {
        $registration = $this->getRegistration();

        if (!$registration) {
            return $this->redirectToRoute('sylius_flow_start', array('scenarioAlias' => 'asamblea'));
        }

        if ($registration->getStatus() != Registration::STATUS_OPEN) {
            return $this->redirectToRoute('registration');
        }

        $this->denyAccessUnlessGranted(['SEATS_AVAILABLE', 'REGISTRATION_OPEN'], $ticket);

        $participant = new Participant();
        $participant->setRegistration($registration);
        $form = $this->createForm($this->get('ritsiga.participant.form.type'), $participant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $participant->setTicket($ticket);
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/registration:participant.html.twig', array(
            'registration' => $registration,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id/edit", name="participant_edit")
     * Muestra pantalla de edición de un participante
     */
    public function editParticipantAction(Request $request, Participant $participant)
    {
        $registration = $participant->getRegistration();

        if (!$registration) {
            return $this->redirectToRoute('sylius_flow_start', array('scenarioAlias' => 'asamblea'));
        }

        if ($registration->getStatus() != Registration::STATUS_OPEN) {
            return $this->redirectToRoute('registration');
        }

        $this->denyAccessUnlessGranted('REGISTRATION_OWNER', $registration);

        $form = $this->createForm($this->get('ritsiga.participant.form.type'), $participant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('registration');
        }

        return $this->render(':frontend/registration:participant.html.twig', array(
            'registration' => $registration,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}/delete", name="participant_delete")
     * Borra la inscripción enviada por argumento
     */
    public function deleteParticipantAction(Participant $participant)
    {
        $registration = $participant->getRegistration();

        $this->denyAccessUnlessGranted('REGISTRATION_OWNER', $registration);

        if ($registration->getStatus() == Registration::STATUS_OPEN) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($participant);
            $em->flush();
        }

        return $this->redirectToRoute('registration');
    }

    /**
     * @Route("/{id}/certificate", name="acreditation_download")
     */
    public function downloadAcreditationAction(Participant $participant)
    {
        $registration = $participant->getRegistration();
        $this->denyAccessUnlessGranted('REGISTRATION_OWNER', $registration);

        return new Response(
            $this->get('ritsiga.business.document_generator')->generateCredentials($participant, $filename),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            )
        );
    }

    /**
     * @Route("/{id}/invoice", name="invoice_download")
     * @Security("is_granted('INVOICE_DOWNLOAD', participant)")
     */
    public function downloadInvoceAction(Participant $participant)
    {
        return new Response(
            $this->get('ritsiga.business.document_generator')->generateInvoice($participant, $filename),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            )
        );
    }
}
