<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 07/09/15
 * Time: 17:38.
 */
namespace AppBundle\EventListener;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class AddUniversityFieldSubscriber implements EventSubscriberInterface
{
    private $factory;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Returns the events to which this class has subscribed.
     *
     * Return format:
     *     array(
     *         array('event' => 'the-event-name', 'method' => 'onEventName', 'class' => 'some-class', 'format' => 'json'),
     *         array(...),
     *     )
     *
     * The class may be omitted if the class wants to subscribe to events of all classes.
     * Same goes for the format key.
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    private function addUniversityForm(FormInterface $form, $university)
    {
        $form->add($this->factory->createNamed('university', 'entity', $university, array(
            'class' => 'AppBundle:University',
            'mapped' => false,
            'auto_initialize' => false,
            'label' => 'label.university',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('university')
                ->orderBy('university.name', 'ASC');

                return $qb;
            },
        )));
    }

    public function preSetData(FormEvent $event)
    {
        /** @var User $data */
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $university = ($data->getStudentDelegation()) ? $data->getStudentDelegation()->getCollege()->getUniversity() : null;
        $this->addUniversityForm($form, $university);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $university = array_key_exists('university', $data) ? $data['university'] : null;
        $this->addUniversityForm($form, $university);
    }
}
