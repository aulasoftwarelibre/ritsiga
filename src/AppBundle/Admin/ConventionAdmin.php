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
            ->with('title.convention_info', ['class' => 'col-md-6'])
                ->add('name', 'text', [
                    'label' => 'label.name',
                ])
                ->add('slug', 'text', [
                    'label' => 'label.slug',
                ])
                ->add('description', null, [
                    'label' => 'Descripción',
                    'required' => false,
                    'attr' => ['class' => 'ckeditor'],
                ])
                ->add('email', 'email', [
                    'label' => 'label.email',
                ])
                ->add('web', 'email', [
                    'label' => 'label.web',
                ])
                ->add('file', 'file', [
                    'label' => 'Imagen',
                    'data_class' => null,
                    'attr' => ['class' => 'filestyle'],
                    'required' => false,
                    'help' => 'help.convention.image',
                ])
                ->add('calendar', null, [
                    'label' => 'label.calendar',
                    'required' => false,
                    'help' => 'help.convention.calendar',
                ])
            ->end()
            ->with('title.convention_parameters', ['class' => 'col-md-6'])
                ->add('administrators', null, [
                    'label' => 'Administradores',
                ])
                ->add('startsAt', 'sonata_type_date_picker', [
                    'label' => 'label.startsAt',
                ])
                ->add('endsAt', 'sonata_type_date_picker', [
                    'label' => 'label.endsAt',
                ])
                ->add('seats', null, [
                    'label' => 'label.seats',
                    'help' => 'help.seats',
                    'required' => true,
                ])
                ->add('reduced_seats', null, [
                    'label' => 'label.reduced_seats',
                    'help' => 'help.reduced_seats',
                    'required' => true,
                ])
                ->add('maintenance', 'checkbox', [
                    'label' => 'label.maintenance',
                    'required' => false,
                ])
                ->add('published_draft', 'checkbox', [
                    'label' => 'label.published_draft',
                    'required' => false,
                ])
                ->add('published_invoices', 'checkbox', [
                    'label' => 'label.published_invoices',
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('startsAt', null, [
                'label' => 'label.startsAt',
            ])
            ->add('endsAt', null, [
                'label' => 'label.endsAt',
            ])
            ->add('email', null, [
                'label' => 'label.email',
            ])
            ->add('image', null, [
                'template' => 'backend/image/image.html.twig',
                'label' => 'Imagen',
            ])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('startsAt', null, [
                'label' => 'label.startsAt',
            ])
            ->add('endsAt', null, [
                'label' => 'label.endsAt',
            ])
            ->add('email', null, [
                'label' => 'label.email',
            ])
            ->add('maintenance', null, [
                'label' => 'label.maintenance',
            ])
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, [
                'label' => 'label.name',
            ])
            ->add('startsAt', null, [
                'label' => 'label.startsAt',
            ])
            ->add('endsAt', null, [
                'label' => 'label.endsAt',
            ])
            ->add('seats', null, [
                'label' => 'label.seats',
            ])
            ->add('reduced_seats', null, [
                'label' => 'label.reduced_seats',
            ])
            ->add('maintenance', 'boolean', [
                'label' => 'label.maintenance',
                'editable' => true,
            ])
            ->add('published_draft', 'boolean', [
                'label' => 'label.published_draft',
                'editable' => true,
            ])
            ->add('published_invoices', 'boolean', [
                'label' => 'label.published_invoices',
                'editable' => true,
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

    public function prePersist($object)
    {
        if ($object->getFile()) {
            $this->getConfigurationPool()->getContainer()->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($object, $object->getFile());
        }
    }

    public function preUpdate($object)
    {
        if ($object->getFile()) {
            $this->getConfigurationPool()->getContainer()->get('stof_doctrine_extensions.uploadable.manager')->markEntityToUpload($object, $object->getFile());
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('acreditation', $this->getRouterIdParameter().'/acreditations');
        $collection->add('invoice', $this->getRouterIdParameter().'/invoices');
    }
}
