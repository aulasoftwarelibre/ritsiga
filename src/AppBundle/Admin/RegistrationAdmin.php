<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 1/05/15
 * Time: 19:19.
 */
namespace AppBundle\Admin;

use AppBundle\Entity\Registration;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RegistrationAdmin extends Admin
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
            $query->andWhere($query->expr()->eq($alias.'.convention', $convention->getId()));
        }

        return $query;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('title.inscriptions', ['class' => 'col-md-12'])
                ->add('convention', null, [
                    'query_builder' => $this->getRepository('convention')->getQueryConvention($this->getCurrentConvention()),
                    'required' => true,
                    'label' => 'label.convention',
                ])
                ->add('user', null, array(
                    'label' => 'label.user',
                ))
                ->add('name', null, array(
                    'label' => 'label.name',
                ))
                ->add('position', null, array(
                    'label' => 'label.position',
                ))
                ->add('status', 'choice', array(
                    'label' => 'label.status',
                    'choices' => Registration::getStatusArrayChoice(),
                    'required' => true,
                ))
            ->end()
            ->with('label.taxdata', ['class' => 'col-md-6'])
                ->add('taxdata.name', null, [
                    'label' => 'label.name',
                ])
                ->add('taxdata.address', 'textarea', [
                    'label' => 'label.address',
                ])
                ->add('taxdata.cif', null, [
                    'label' => 'label.cif',
                ])
            ->end()
            ->with('title.travel_info', ['class' => 'col-md-6'])
                ->add('arrivaldate', 'sonata_type_date_picker', [
                    'label' => 'label.arrivaldate',
                    'required' => false,
                ])
                ->add('departuredate', 'sonata_type_date_picker', [
                    'label' => 'label.departuredate',
                    'required' => false,
                ])
                ->add('transport', null, [
                    'label' => 'label.transport',
                    'required' => false,
                ])
                ->add('comentary', null, [
                    'label' => 'label.comentary',
                    'required' => false,
                ])
            ->end()
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('label.registration', ['class' => 'col-md-6'])
                ->add('id', null, [
                    'label' => 'label.id_transfer',
                ])
                ->add('convention', null, [
                    'label' => 'label.convention',
                ])
                ->add('status', 'choice', [
                    'label' => 'label.status',
                    'choices' => Registration::getStatusArrayChoice(),
                    'catalogue' => 'messages',
                ])
                ->add('user', null, [
                    'label' => 'label.user',
                ])
                ->add('user.university', null, [
                    'label' => 'label.university',
                ])
                ->add('user.college', null, [
                    'label' => 'label.college',
                ])
                ->add('participants', null, [
                    'label' => 'label.participants',
                ])
            ->end()
            ->with('title.travel_info', ['class' => 'col-md-6'])
                ->add('arrivaldate', 'date', [
                    'label' => 'label.arrivaldate',
                    'format' => 'd/m/Y H:i',
                ])
                ->add('departuredate', 'date', [
                    'label' => 'label.departuredate',
                    'format' => 'd/m/Y H:i',
                ])
                ->add('transport', null, [
                    'label' => 'label.transport',
                ])
                ->add('comentary', null, [
                    'label' => 'label.comentary',
                ])
            ->end()
            ->with('label.certificate_data', ['class' => 'col-md-6'])
                ->add('name', null, [
                    'label' => 'label.name',
                ])
                ->add('position', null, [
                    'label' => 'label.position',
                ])
            ->end()
            ->with('label.taxdata', ['class' => 'col-md-6'])
                ->add('taxdata.name', null, [
                    'label' => 'label.name',
                ])
                ->add('taxdata.address', null, [
                    'label' => 'label.address',
                ])
                ->add('taxdata.cif', null, [
                    'label' => 'label.cif',
                ])
            ->end()
        ;
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id', null, [
                'label' => 'label.id_transfer',
            ])
            ->add('convention', null, array('label' => 'label.convention'))
            ->add('name', null, array('label' => 'label.name'))
            ->add('position', null, array('label' => 'label.position'))
            ->add('status', null, array(
                'label' => 'label.status',
            ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id', null, [
                'label' => 'label.id_transfer',
            ])
            ->add('user.university', null, [
                'label' => 'label.university',
            ])
            ->add('user.college', null, [
                'label' => 'label.college',
            ])
            ->add('status', 'choice', [
                'label' => 'label.status',
                'choices' => Registration::getStatusArrayChoice(),
                'catalogue' => 'messages',
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'edit' => [],
                    'show' => [],
                ],
            ])
        ;
    }
}
