<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/04/15
 * Time: 21:48.
 */
namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CollegeAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'university',  // name of the ordered field
    );

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('title.college_data', ['class' => 'col-md-6'])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('university', null, [
                    'label' => 'label.university',
                ])
                ->add('academic_degrees', null, [
                    'label' => 'label.academic_degrees',
                ])
            ->end()
            ->with('title.contact_data', ['class' => 'col-md-6'])
                ->add('address', 'textarea', [
                    'label' => 'label.address',
                ])
                ->add('city', null, [
                    'label' => 'label.city',
                ])
                ->add('province', null, [
                    'label' => 'label.province',
                ])
                ->add('postcode', null, [
                    'label' => 'label.postcode',
                ])
                ->add('phone', null, [
                    'label' => 'label.phone',
                ])
                ->add('fax', null, [
                    'label' => 'label.fax',
                ])
                ->add('web', null, [
                    'label' => 'label.web',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('title.college_data', ['class' => 'col-md-6'])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('university', null, [
                    'label' => 'label.university',
                ])
                ->add('slug', null, [
                    'label' => 'label.slug',
                ])
                ->add('academic_degrees', null, [
                    'label' => 'label.academic_degrees',
                ])
            ->end()
            ->with('title.contact_data', ['class' => 'col-md-6'])
                ->add('address', 'textarea', [
                    'label' => 'label.address',
                ])
                ->add('city', null, [
                    'label' => 'label.city',
                ])
                ->add('province', null, [
                    'label' => 'label.province',
                ])
                ->add('postcode', null, [
                    'label' => 'label.postcode',
                ])
                ->add('phone', null, [
                    'label' => 'label.phone',
                ])
                ->add('fax', null, [
                    'label' => 'label.fax',
                ])
                ->add('web', null, [
                    'label' => 'label.web',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('university', null, [
                'label' => 'label.university',
            ])
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('city', null, [
                'label' => 'label.city',
            ])
            ->add('province', null, [
                'label' => 'label.province',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, [
                'label' => 'label.name',
            ])
            ->add('university', null, [
                'label' => 'label.university',
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'name'],
                'sort_parent_association_mappings' => [['fieldName' => 'university']],
            ])
            ->add('city', null, [
                'label' => 'label.city',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'show' => [],
                ],
                'label' => 'label.actions',
            ])
        ;
    }
}
