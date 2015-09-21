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
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ParticipantController.
 *
 * @Route(path="/convention/{slug}")
 */
class ParticipantController extends Controller
{
    /**
     * @Route("/nueva-inscripcion/{ticket}", name="participant_new")
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
     * @Route("/editar-inscripcion/{id}", name="participant_edit")
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
     * @Route("/borrar_inscripcion/{id}", name="participant_delete")
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
}
