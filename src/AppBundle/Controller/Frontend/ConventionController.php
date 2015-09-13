<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 19/04/15
 * Time: 20:24.
 */
namespace AppBundle\Controller\Frontend;

use AppBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ConventionController.
 *
 * @Route(path="/convention/{slug}")
 */
class ConventionController extends Controller
{
    /**
     * @Route("/", name="convention")
     */
    public function showConvention()
    {
        return $this->render('frontend/conventions/convention.html.twig');
    }
}
