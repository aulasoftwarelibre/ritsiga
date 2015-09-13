<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 28/03/15
 * Time: 11:13.
 */
namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ConventionAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $alias = current($query->getRootAliases());
        $convention = $this->getConfigurationPool()->getContainer()->get('ritsiga.site.manager')->getCurrentSite();

        if ($convention->getId()) {
            $query->andWhere($query->expr()->eq($alias.'.id', $convention->getId()));
        }

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'label.name'))
            ->add('slug', 'text', array('label' => 'label.slug'))
            ->add('description', null, array(
                'label' => 'Descripción',
                'required' => false,
                'attr' => array('class' => 'ckeditor'),
            ))
            ->add('startsAt', 'sonata_type_date_picker', array('label' => 'label.startsAt'))
            ->add('endsAt', 'sonata_type_date_picker', array('label' => 'label.endsAt'))
            ->add('seats', null, array(
                'label' => 'label.seats',
                'help' => 'help.seats',
                'required' => true,
            ))
            ->add('reduced_seats', null, array(
                'label' => 'label.reduced_seats',
                'help' => 'help.reduced_seats',
                'required' => true,
            ))
            ->add('email', 'email', array('label' => 'label.email'))
            ->add('web', 'email', array('label' => 'label.web'))
            ->add('administrators', null, array('label' => 'Administradores'))
            ->add('image', 'file', array(
                'label' => 'Imagen',
                'data_class' => null,
                'attr' => ['class' => 'filestyle'],
                'required' => false,
            ))
            ->add('maintenance', 'checkbox', array(
                'label' => 'label.maintenance',
                'required' => false,
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('startsAt', null, array('label' => 'label.startsAt'))
            ->add('endsAt', null, array('label' => 'label.endsAt'))
            ->add('email')
            ->add('image', null, array(
                'template' => 'backend/image/image.html.twig',
                'label' => 'Imagen',
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('startsAt', null, array('label' => 'label.startsAt'))
            ->add('endsAt', null, array('label' => 'label.endsAt'))
            ->add('email', null, array('label' => 'label.email'))
            ->add('maintenance', null, array('label' => 'label.maintenance'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array('label' => 'label.name'))
            ->add('startsAt', null, array('label' => 'label.startsAt'))
            ->add('endsAt', null, array('label' => 'label.endsAt'))
            ->add('seats', null, array(
                'label' => 'label.seats',
            ))
            ->add('reduced_seats', null, array(
                'label' => 'label.reduced_seats',
            ))
            ->add('_action', 'actions', array(
                'label' => 'label.action',
            'actions' => array(
                'delete' => array(),
                'edit' => array(),
                'show' => array(
                    'template' => 'CRUD/list__show_convention.html.twig',
                ),
                'download_acreditation' => array(
                    'template' => 'CRUD/list__action_acreditation.html.twig',
                ),
                'download_invoice' => array(
                    'template' => 'CRUD/list__action_invoice.html.twig',
                ),
            ), ))
        ;
    }

    public function prePersist($object)
    {
        if ($object->getImage()) {
            $this->getConfigurationPool()->getContainer()->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($object, $object->getImage());
        }
    }

    public function preUpdate($object)
    {
        if ($object->getImage()) {
            $this->getConfigurationPool()->getContainer()->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($object, $object->getImage());
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('acreditation', $this->getRouterIdParameter().'/acreditations');
        $collection->add('invoice', $this->getRouterIdParameter().'/invoices');
    }
}
