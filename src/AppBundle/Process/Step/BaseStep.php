<?php

/**
 * Created by PhpStorm.
 * User: sergio
 * Date: 11/09/15
 * Time: 19:10.
 */
namespace AppBundle\Process\Step;

use Sylius\Bundle\FlowBundle\Process\Step\ControllerStep;

abstract class BaseStep extends ControllerStep
{
    public function getCurrentSite()
    {
        return $this->container->get('ritsiga.site.manager')->getCurrentSite();
    }
}
