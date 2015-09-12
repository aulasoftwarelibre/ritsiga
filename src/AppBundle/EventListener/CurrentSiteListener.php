<?php
/**
 * Created by PhpStorm.
 * User: tfg
 * Date: 12/04/15
 * Time: 19:22
 */

namespace AppBundle\EventListener;
use AppBundle\Entity\Convention;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Doctrine\ORM\EntityManager;
use AppBundle\Site\SiteManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;

class CurrentSiteListener {
    private $siteManager;

    private $em;

    private $baseSlug;
    /**
     * @var KernelInterface
     */
    private $kernel;
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(SiteManager $siteManager, EntityManager $em, RouterInterface $router, $baseSlug)
    {
        $this->siteManager = $siteManager;
        $this->em = $em;
        $this->baseSlug = $baseSlug;
        $this->router = $router;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $context = $this->router->getContext();
        preg_match('/^\/convention\/([a-z]\w+)/', $context->getPathInfo(), $matches);
        $slug = isset($matches[1]) ? $matches[1] : $this->baseSlug;

        if (!$context->hasParameter('slug')) {
            $context->setParameter('slug', $slug);
        }

        if ($this->baseSlug == $slug) {
            $site = new Convention();
            $site->setSlug('ritsi');
            $this->siteManager->setCurrentSite($site);
            return;
        }

        $site = $this->em
            ->getRepository('AppBundle:Convention')
            ->findOneBy(array('slug' => $slug));
        if (!$site) {
            throw new NotFoundHttpException(sprintf(
                'No site for slug "%s"',
                $slug
            ));
        }
        $this->siteManager->setCurrentSite($site);
    }
}