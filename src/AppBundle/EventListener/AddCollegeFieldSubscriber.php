<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 07/09/15
 * Time: 17:38
 */

namespace AppBundle\EventListener;


use AppBundle\Entity\University;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class AddCollegeFieldSubscriber implements EventSubscriberInterface
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

    private function addCollegeForm(FormInterface $form, $college, $university)
    {
        $form->add($this->factory->createNamed('college', 'entity', $college, array(
            'class'         => 'AppBundle:College',
            'mapped'        => false,
            'auto_initialize' => false,
            'label'         => 'label.college',
            'query_builder' => function (EntityRepository $repository) use ($university) {
                $qb = $repository->createQueryBuilder('college')
                    ->innerJoin('college.university', 'university');
                if ($university instanceof University) {
                    $qb->where('college.university = :university')
                        ->setParameter('university', $university);
                } elseif (is_numeric($university)) {
                    $qb->where('university.id = :university')
                        ->setParameter('university', $university);
                } else {
                    $qb->where('university.name = :university')
                        ->setParameter('university', null);
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
        $university = ($college) ? $college->getUniversity() : null ;
        $this->addCollegeForm($form, $college, $university);
    }

    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        if (null === $data) {
            return;
        }

        $college = array_key_exists('college', $data) ? $data['college'] : null ;
        $university = array_key_exists('university', $data) ? $data['university'] : null ;
        $this->addCollegeForm($form, $college, $university);
    }
}