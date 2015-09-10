<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 30/07/15
 * Time: 17:56
 */

namespace AppBundle\Security\Handler;


use AppBundle\Site\SiteManager;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Security\Handler\RoleSecurityHandler;

class RoleConventionSecurityHandler extends RoleSecurityHandler
{
    /**
     * @var SiteManager
     */
    protected $siteManager;

    public function __construct($authorizationChecker, array $superAdminRoles, SiteManager $siteManager)
    {
        parent::__construct($authorizationChecker, $superAdminRoles);
        $this->siteManager = $siteManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseRole(AdminInterface $admin)
    {
        $code = $this->siteManager->getCurrentSite()->getDomain();
        return 'ROLE_'.str_replace('.', '_', strtoupper($code . "." . $admin->getCode())).'_%s';
    }
}