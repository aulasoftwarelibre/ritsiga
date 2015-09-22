<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 4/06/15
 * Time: 13:37.
 */
namespace AppBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResponsibleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'label.name',
                'attr' => array(
                    'field_help' => 'help.responsible_name',
                ),
            ))
            ->add('position', null, array(
                'label' => 'label.position',
                'attr' => array(
                    'field_help' => 'help.responsible_position',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Registration',
            'validation_groups' => ['Default', 'taxdata'],
        ));
    }

    public function getName()
    {
        return 'registration';
    }
}
