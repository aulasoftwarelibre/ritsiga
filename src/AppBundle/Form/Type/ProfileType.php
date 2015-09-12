<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 10/05/15
 * Time: 18:07.
 */
namespace AppBundle\Form\Type;

use AppBundle\EventListener\AddCollegeFieldSubscriber;
use AppBundle\EventListener\AddStudentDelegationFieldSubscriber;
use AppBundle\EventListener\AddUniversityFieldSubscriber;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factory = $builder->getFormFactory();
        $universitySubscriber = new AddUniversityFieldSubscriber($factory);
        $builder->addEventSubscriber($universitySubscriber);
        $collegeSubscriber = new AddCollegeFieldSubscriber($factory);
        $builder->addEventSubscriber($collegeSubscriber);
        $studentDelegationSubscriber = new AddStudentDelegationFieldSubscriber($factory);
        $builder->addEventSubscriber($studentDelegationSubscriber);

        $builder
            ->add('firstname', null, array(
                'label' => 'label.name',
            ))
            ->add('lastname', null, array(
                'label' => 'label.last_name',
            ))
            ->add('email')
            ->add('phone', null, array(
                'label' => 'label.phone',
            ))
            ->add('website', null, array(
                'label' => 'label.website',
            ));
    }

    public function getName()
    {
        return 'ritsiga_user_profile';
    }
}
