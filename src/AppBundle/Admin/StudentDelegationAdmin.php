<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/04/15
 * Time: 21:51
 */

namespace AppBundle\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class StudentDelegationAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'college.university.name'  // name of the ordered field
    );

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('address', null, array('label' => 'label.address'))
            ->add('city', null, array('label' => 'label.city'))
            ->add('province', null, array('label' => 'label.province'))
            ->add('postcode', null, array('label' => 'label.postcode'))
            ->add('college', null, array('label' => 'label.college'))
            ->add('slug');
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('address', null, array('label' => 'label.address'))
            ->add('city', null, array('label' => 'label.city'))
            ->add('province', null, array('label' => 'label.province'))
            ->add('postcode', null, array('label' => 'label.postcode'))
            ->add('phone', null, array('label' => 'label.phone'))
            ->add('fax')
            ->add('web', 'url')
            ->add('cif')
            ->add('college', null, array('label' => 'label.college'))
            ->add('college.university')
            ->add('slug');
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('city', null, array('label' => 'label.city'))
            ->add('province', null, array('label' => 'label.province'))
            ->add('college', null, array('label' => 'label.college'))
            ->add('college.university', null, array('label' => 'label.university'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'label.name'))
            ->add('college', null, array('label' => 'label.college'))
            ->add('college.university', null, array('label' => 'label.university'))
            ->add('_action', 'actions', array(
                'label' => 'label.actions',
                'actions' => array(
                    'edit' => array(),
                    'show' => array(),
                )))
        ;
    }
}