<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/06/15
 * Time: 12:46.
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentDelegationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('city', null, [
                'label' => 'label.city',
            ])
            ->add('province', null, [
                'label' => 'label.province',
            ])
            ->add('address', 'textarea', [
                'label' => 'label.address',
            ])
            ->add('postcode', null, [
                'label' => 'label.postcode',
            ])
            ->add('email', 'email', [
                'label' => 'label.email',
                'required' => true,
            ])
            ->add('web', null, [
                'label' => 'label.web',
            ])
            ->add('fax', null, [
                'label' => 'label.fax',
            ])
            ->add('phone', null, [
                'label' => 'label.phone',
            ])
            ->add('cif', null, [
                'label' => 'label.cif',
                'required' => false,
            ])
            ->add('facebook', null, [
                'label' => 'label.facebook',
            ])
            ->add('twitter', null, [
                'label' => 'label.twitter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StudentDelegation',
        ));
    }

    public function getName()
    {
        return 'student_delegation';
    }
}
