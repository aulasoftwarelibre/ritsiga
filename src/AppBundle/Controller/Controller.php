<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 13/09/15
 * Time: 08:23.
 */
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function getConvention()
    {
        return $this->container->get('ritsiga.site.manager')->getCurrentSite();
    }

    public function getRegistration()
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException();
        }

        return $this->getDoctrine()->getRepository('AppBundle:Registration')->findOneBy([
            'user' => $user,
            'convention' => $this->getConvention(),
        ]);
    }

    protected function addFlash($type, $message)
    {
        $message = $this->get('translator')->trans($message, [], 'flashes');
        parent::addFlash($type, $message);
    }
}
