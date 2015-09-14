<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 3/08/15
 * Time: 19:48.
 */
namespace AppBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class TravelInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departuredate', 'collot_datetime', array(
                'label' => 'label.departuredate',
                'required' => false,
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy hh:ii',
                    'weekStart' => 1,
                    'autoclose' => true,
                ),
            ))
            ->add('arrivaldate', 'collot_datetime', array(
                'label' => 'label.arrivaldate',
                'required' => false,
                'pickerOptions' => array(
                    'format' => 'dd/mm/yyyy hh:ii',
                    'weekStart' => 1,
                    'autoclose' => true,
                ),
            ))
            ->add('transport', null, array('label' => 'label.transport'))
            ->add('comentary', null, array('label' => 'label.comentary'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Registration',
            'validation_groups' => 'travel',
        ));
    }

    public function getName()
    {
        return 'registration';
    }
}
