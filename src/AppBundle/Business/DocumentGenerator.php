<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 17/09/15
 * Time: 01:11.
 */
namespace AppBundle\Business;

use AppBundle\Entity\Participant;
use AppBundle\Entity\Registration;
use Knp\Bundle\SnappyBundle\Snappy\LoggableGenerator;

class DocumentGenerator
{
    /**
     * @var LoggableGenerator
     */
    protected $loggableGenerator;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * AbstractDocumentGenerator constructor.
     */
    public function __construct(LoggableGenerator $loggableGenerator, \Twig_Environment $twig)
    {
        $this->loggableGenerator = $loggableGenerator;
        $this->twig = $twig;
    }

    /**
     * Genera una acreditación para el usuario indicado.
     *
     * @param Participant $participant
     * @param $filename
     *
     * @return string
     */
    public function generateCredentials(Participant $participant, &$filename)
    {
        $filename = sprintf('acreditacion-%s-%d-%s.pdf',
            $participant->getRegistration()->getConvention()->getSlug(),
            $participant->getRegistration()->getId(),
            $participant->getSlug()
        );

        $html = $this->twig->render('themes/acreditation/acreditation.html.twig', array(
            'participant' => $participant,
            'registration' => $participant->getRegistration(),
        ));

        return $this->loggableGenerator->getOutputFromHtml($html);
    }

    public function generateInvoice(Participant $participant, &$filename)
    {
        $filename = sprintf('factura-%s-%d-%s.pdf',
            $participant->getRegistration()->getConvention()->getSlug(),
            $participant->getRegistration()->getId(),
            $participant->getSlug()
        );

        $html = $this->twig->render('themes/invoice/invoice.html.twig', array(
            'participant' => $participant,
            'registration' => $participant->getRegistration(),
        ));

        return $this->loggableGenerator->getOutputFromHtml($html);
    }

    /**
     * Genera una factura para la inscripción indicada.
     *
     * @param Registration $registration
     * @param $filename
     *
     * @return string
     */
    public function generateInvoiceDraft(Registration $registration, &$filename)
    {
        $filename = sprintf('factura-%s-%d-%s.pdf',
            $registration->getConvention()->getSlug(),
            $registration->getId(),
            $registration->getUser()->getUniversity()->getSlug()
        );

        $html = $this->twig->render('themes/invoice/invoice_draft.html.twig', array(
            'registration' => $registration,
            'fecha' => new \DateTime('today'),
        ));

        return $this->loggableGenerator->getOutputFromHtml($html);
    }
}
