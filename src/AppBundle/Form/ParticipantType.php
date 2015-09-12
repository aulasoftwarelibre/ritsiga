<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/05/15
 * Time: 22:20.
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array(
                'label' => 'label.name',
            ))
            ->add('last_name', null, array(
                'label' => 'label.last_name',
            ))
            ->add('email')
            ->add('phone', null, array(
                'label' => 'label.phone',
            ))
            ->add('dni')
            ->add('dateOfBirth', 'collot_datetime', array(
                'label' => 'label.date_of_birth',
                'required' => 'true',
                'pickerOptions' => array(
                    'startView' => 'decade',
                    'minView' => 'month',
                    'format' => 'yyyy/mm/dd',
                    'weekStart' => 1,
                    'autoclose' => true,
                    'initialDate' => '1990/01/01',
                ),
            ))
            ->add('size', 'choice', array(
                'label' => 'label.size',
                'placeholder' => 'help.select_size',
                'choices' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
                'choices_as_values' => true,
                'choice_label' => function ($currentChoiceKey) {
                    return $currentChoiceKey;
                },
                'attr' => array(
                    'field_help' => 'help.participant_size',
                ),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Participant',
        ));
    }

    public function getName()
    {
        return 'participant';
    }
}
