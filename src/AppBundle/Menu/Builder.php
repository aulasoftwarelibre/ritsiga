<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 29/04/15
 * Time: 23:53.
 */
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttributes(array('class' => 'sidebar-menu'));

        $menu->addChild('Inicio', array('route' => 'homepage'));
        $menu->addChild('Mi Perfil', array('route' => 'fos_user_profile_edit', 'route' => 'fos_user_profile_show'));
        $menu->addChild('Mis inscripciones', array('route' => 'registration', 'route' => 'registration_list'));

        return $menu;
    }
}
