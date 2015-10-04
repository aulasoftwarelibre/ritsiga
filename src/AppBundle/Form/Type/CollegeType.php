<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 2/05/15
 * Time: 10:02.
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollegeType extends AbstractType
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
            ->add('web', null, [
                'label' => 'label.web',
            ])
            ->add('fax', null, [
                'label' => 'label.fax',
            ])
            ->add('phone', null, [
                'label' => 'label.phone',
            ])
            ->add('academic_degrees', null, [
                'label' => 'label.academic_degrees',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\College',
        ));
    }

    public function getName()
    {
        return 'college';
    }
}
