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
            ->add('convention', null, [
                'query_builder' => $this->getRepository('convention')->getQueryConvention($this->getCurrentConvention()),
                'required' => true,
                'label' => 'label.convention',
            ])
            ->add('user', null, array('label' => 'label.user'))
            ->add('name', null, array('label' => 'label.name'))
            ->add('position', null, array('label' => 'label.position'))
            ->add('status', 'choice', array('label' => 'label.status', 'choices' => array(Registration::STATUS_OPEN => 'Abierta', Registration::STATUS_CONFIRMED => 'Confirmada', Registration::STATUS_CANCELLED => 'Cancelada', Registration::STATUS_PAID => 'Pagada'),
        'required' => true, ))
            ->add('invoicenumber', null, array('label' => 'label.invoicenumber'))
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('convention', null, array('label' => 'label.convention'))
            ->add('name', null, array('label' => 'label.name'))
            ->add('position', null, array('label' => 'label.position'))
            ->add('status', null, array('label' => 'label.status'))
            ->add('invoicenumber', null, array('label' => 'label.invoicenumber'))
        ;
    }
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('convention', null, array('label' => 'label.convention'))
            ->add('name', null, array('label' => 'label.name'))
            ->add('position', null, array('label' => 'label.position'))
            ->add('status', null, array('label' => 'label.status'))
            ->add('invoicenumber', null, array('label' => 'label.invoicenumber'))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('user.university', null, array(
                'label' => 'label.university',
            ))
            ->add('user.college', null, array(
                'label' => 'label.college',
            ))
            ->add('status', null, array('label' => 'label.status'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'show' => array(),
                ), ))
        ;
    }
}
