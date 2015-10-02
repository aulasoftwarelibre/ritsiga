<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 25/07/15
 * Time: 10:51.
 */
namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ParticipantAdmin  extends Admin
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
            $query->leftJoin($alias.'.registration', 'registration');
            $query->andWhere($query->expr()->eq('registration.convention', $convention->getId()));
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('title.registration_data', ['class' => 'col-md-6'])
                ->add('registration', null, [
                    'query_builder' => $this->getRepository('registration')->getQueryRegistration($this->getCurrentConvention()),
                    'required' => true,
                    'label' => 'label.registration',
                    'choice_label' => 'description',
                    'help' => 'help.admin_registration',
                    'property' => 'getDescription',
                ])
                ->add('ticket', null, [
                    'query_builder' => $this->getRepository('ticket')->getTicketsAvailability($this->getCurrentConvention()),
                    'required' => true,
                    'label' => 'label.ticket',
                ])
                ->add('invoice_number', null, [
                    'label' => 'label.invoice_number',
                ])
            ->end()
            ->with('title.personal_data', ['class' => 'col-md-6'])
                ->add('dni', null, [
                    'label' => 'label.dni',
                ])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('last_name', null, [
                    'label' => 'label.last_name',
                ])
                ->add('email', null, [
                    'label' => 'label.email',
                ])
                ->add('phone', null, [
                    'label' => 'label.phone',
                ])
                ->add('dateOfBirth', null, [
                    'label' => 'label.date_of_birth',
                ])
                ->add('size', null, [
                    'label' => 'label.size',
                ])
            ->end()

        ;
    }

    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('title.registration_data', ['class' => 'col-md-6'])
                ->add('registration.convention', null, [
                    'label' => 'label.convention',
                ])
                ->add('registration', null, [
                    'label' => 'label.registration',
                    'associated_tostring' => 'getDescription',
                ])
                ->add('ticket', null, [
                    'label' => 'label.ticket',
                ])
                ->add('invoice_number', null, [
                    'label' => 'label.invoice_number',
                ])
            ->end()
            ->with('title.personal_data', ['class' => 'col-md-6'])
                ->add('dni', null, [
                    'label' => 'label.dni',
                ])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('last_name', null, [
                    'label' => 'label.last_name',
                ])
                ->add('email', null, [
                    'label' => 'label.email',
                ])
                ->add('phone', null, [
                    'label' => 'label.phone',
                ])
                ->add('dateOfBirth', null, [
                    'label' => 'label.date_of_birth',
                ])
                ->add('size', null, [
                    'label' => 'label.size',
                ])
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('last_name', null, [
                'label' => 'label.last_name',
            ])
            ->add('dni', null, [
                'label' => 'label.dni',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, [
                'label' => 'label.name',
            ])
            ->add('last_name', null, [
                'label' => 'label.last_name',
            ])
            ->add('invoice_number', null, [
                'label' => 'label.invoice_number',
                'editable' => true,
            ])
            ->add('registration', null, [
                'label' => 'label.registration',
                'associated_tostring' => 'getDescription',
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

    /**
     * Devuelve los campos que se van a exportar para esta tabla
     *
     * @return array
     */
    public function getExportFields()
    {
        return [
            'dni',
            'name',
            'last_name',
            'email',
            'phone',
            'dateOfBirth',
            'size',
            'registration.description',
            'ticket',
            'invoice_number',
            'registration.user.university',
            'registration.user.college',
        ];
    }
}
