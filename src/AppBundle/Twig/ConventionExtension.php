<?php

/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 3/05/15
 * Time: 17:27.
 */
namespace AppBundle\Twig;

use AppBundle\Site\SiteManager;
use Symfony\Component\HttpFoundation\RequestStack;
use AppBundle\Entity\Convention;

class ConventionExtension extends \Twig_Extension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SiteManager
     */
    private $siteManager;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct($requestStack, SiteManager $siteManager)
    {
        $this->siteManager = $siteManager;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return [
            'convention' => $this->getCurrentConvention(),
        ];
    }

    /**
     * Returns the current convention.
     *
     * @return Convention
     */
    public function getCurrentConvention()
    {
        return $this->siteManager->getCurrentSite();
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ritsiGA_conference';
    }
}
