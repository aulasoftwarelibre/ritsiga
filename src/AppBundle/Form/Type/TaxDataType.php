<?php
/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 21/09/15
 * Time: 20:29
 */

namespace AppBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaxDataType extends AbstractType
{
    /**
     * @{inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'label.name',
                'required' => true,
            ])
            ->add('address', 'textarea', [
                'label' => 'label.address',
                'required' => true,
            ])
            ->add('city', null, [
                'label' => 'label.city',
                'required' => true,
            ])
            ->add('province', null, [
                'label' => 'label.province',
                'required' => true,
            ])
            ->add('postcode', null, [
                'label' => 'label.postcode',
                'required' => true,
            ])
            ->add('cif', null, [
                'label' => 'label.cif',
                'required' => true,
            ])
        ;
    }

    /**
     * @{@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\TaxData',
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'taxdata';
    }
}