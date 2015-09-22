<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 22/09/15
 * Time: 21:17.
 */
namespace AppBundle\Security\Voter;

use AppBundle\Entity\Participant;
use AppBundle\Entity\Registration;
use Symfony\Component\Security\Core\Authorization\Voter\AbstractVoter;
use Symfony\Component\Security\Core\User\UserInterface;

class InvoiceVoter extends AbstractVoter
{
    /**
     * Return an array of supported classes. This will be called by supportsClass.
     *
     * @return array an array of supported classes, i.e. array('Acme\DemoBundle\Model\Product')
     */
    protected function getSupportedClasses()
    {
        return [
            'AppBundle\Entity\Participant',
        ];
    }

    /**
     * Return an array of supported attributes. This will be called by supportsAttribute.
     *
     * @return array an array of supported attributes, i.e. array('CREATE', 'READ')
     */
    protected function getSupportedAttributes()
    {
        return [
            'INVOICE_DOWNLOAD',
        ];
    }

    /**
     * Solo el usuario creador de la inscripción podrá descargar la factura si:
     * - Está pagada.
     * - Están publicadas.
     * - Tiene número de factura.
     *
     * @param string               $attribute
     * @param Participant          $object
     * @param UserInterface|string $user
     *
     * @return bool
     */
    protected function isGranted($attribute, $object, $user = null)
    {
        if (!$user instanceof UserInterface) {
            return false;
        }

        $registration = $object->getRegistration();

        if ($registration->getStatus() !== Registration::STATUS_PAID) {
            return false;
        }

        if (!$registration->getConvention()->isPublishedInvoices()) {
            return false;
        }

        if (empty($object->getInvoiceNumber())) {
            return false;
        }

        return $user == $registration->getUser();
    }
}
