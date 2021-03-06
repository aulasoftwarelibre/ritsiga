<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 18/08/15
 * Time: 15:46.
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\Registration;
use AppBundle\Event\RegistrationEvent;
use AppBundle\Event\RegistrationEvents;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class NotificationListener implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onRegistrationConfirmed(RegistrationEvent $event)
    {
        $registration = $event->getRegistration();
        $user = $registration->getUser();
        $systemMailer = $this->container->get('system_mailer');
        $systemMailer->send('App:confirmed_registration', ['user' => $user, 'registration' => $registration], 'es');
    }

    public function onRegistrationPaid(RegistrationEvent $event)
    {
        $registration = $event->getRegistration();
        $user = $registration->getUser();
        $systemMailer = $this->container->get('system_mailer');
        $systemMailer->send('App:confirmed_registration', ['user' => $user, 'registration' => $registration], 'es');
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     *
     * @api
     */
    public static function getSubscribedEvents()
    {
        return array(
            RegistrationEvents::CONFIRMED => 'onRegistrationConfirmed',
            RegistrationEvents::PAID => 'onRegistrationPaid',
        );
    }

    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if ($eventArgs->getEntity() instanceof Registration) {
            if ($eventArgs->hasChangedField('status') && $eventArgs->getNewValue('status') == 'paid') {
                $registration = $eventArgs->getEntity();
                $user = $registration->getUser();
                $systemMailer = $this->container->get('system_mailer');
                $systemMailer->send('App:paid_registration', ['user' => $user, 'registration' => $registration], 'es');
            }
        }
    }
}
