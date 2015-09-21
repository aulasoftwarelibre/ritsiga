<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 31/05/15
 * Time: 18:39.
 */
namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TicketAdmin  extends Admin
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

    public function prePersist($ticket)
    {
        $convention = $this->getConfigurationPool()->getContainer()->get('ritsiga.site.manager')->getCurrentSite();
        $ticket->setConvention($convention);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('convention', null, [
                'query_builder' => $this->getRepository('convention')->getQueryConvention($this->getCurrentConvention()),
                'required' => true,
                'label' => 'label.convention',
            ])
            ->add('name', null, array(
                'label' => 'label.name',
            ))
            ->add('description', null, array(
                'label' => 'label.description',
            ))
            ->add('reduced', null, array(
                'label' => 'label.reduced',
                'help' => 'help.reduced',
            ))
            ->add('public', null, array(
                'label' => 'label.public',
                'help' => 'help.public',
            ))
            ->add('startDate', 'sonata_type_date_picker', array(
                'label' => 'label.startsAt',
                'help' => 'help.startsAt',
            ))
            ->add('endDate', 'sonata_type_date_picker', array(
                'label' => 'label.endsAt',
                'help' => 'help.endsAt',
            ))
            ->add('price', null, array(
                'label' => 'label.price',
            ))
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('description', null, array('label' => 'label.description'))
            ->add('startDate', null, array('label' => 'label.startsAt'))
            ->add('endDate', null, array('label' => 'label.endsAt'))
            ->add('price', null, array('label' => 'label.price'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('startDate', null, array('label' => 'label.startsAt'))
            ->add('endDate', null, array('label' => 'label.endsAt'))
            ->add('price', null, array('label' => 'label.price'))
            ->add('reduced', 'boolean', array(
                'label' => 'label.reduced',
                'editable' => true,
            ))
            ->add('public', 'boolean', array(
                'label' => 'label.public',
                'editable' => true,
            ))
            ->add('_action', 'actions', array(
                'label' => 'label.actions',
                'actions' => array(
                    'edit' => array(),
                    'show' => array(),
                ),
            ))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name', null, array('label' => 'label.name'))
            ->add('convention', null, array('label' => 'label.convention'))
            ->add('description', null, array('label' => 'label.description'))
            ->add('reduced', 'boolean', array('label' => 'label.reduced'))
            ->add('public', 'boolean', array('label' => 'label.public'))
            ->add('startDate', null, array('label' => 'label.startsAt'))
            ->add('endDate', null, array('label' => 'label.endsAt'))
            ->add('price', null, array('label' => 'label.price'))
        ;
    }
}
