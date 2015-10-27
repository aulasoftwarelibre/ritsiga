<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 3/10/15
 * Time: 23:26.
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniversityType extends AbstractType
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
            ->add('email', 'email', [
                'label' => 'label.email',
                'required' => false,
            ])
            ->add('cif', null, [
                'label' => 'label.cif',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\University',
            'validation_groups' => ['Default', 'taxdata'],
        ));
    }

    public function getName()
    {
        return 'university';
    }
}
