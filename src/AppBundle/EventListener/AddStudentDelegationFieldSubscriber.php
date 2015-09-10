<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 07/09/15
 * Time: 17:38
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\College;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class AddStudentDelegationFieldSubscriber implements EventSubscriberInterface
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

    private function addStudentDelegationForm(FormInterface $form, $college)
    {
        $form->add($this->factory->createNamed('studentdelegation','entity', null, array(
            'class'         => 'AppBundle:StudentDelegation',
            'auto_initialize' => false,
            'label'         => 'label.student_delegation',
            'query_builder' => function (EntityRepository $repository) use ($college) {
                $qb = $repository->createQueryBuilder('student')
                    ->innerJoin('student.college', 'college');
                if ($college instanceof College) {
                    $qb->where('student.college = :college')
                        ->setParameter('college', $college);
                } elseif (is_numeric($college)) {
                    $qb->where('college.id = :college')
                        ->setParameter('college', $college);
                } else {
                    $qb->where('college.name = :college')
                        ->setParameter('college', null);
                }

                return $qb;
            }
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

        $college = ($data->getStudentDelegation()) ? $data->getStudentDelegation()->getCollege() : null ;
        $this->addStudentDelegationForm($form, $college);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $college = array_key_exists('college', $data) ? $data['college'] : null ;
        $this->addStudentDelegationForm($form, $college);
    }
}