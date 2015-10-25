<?php

namespace IPCApplicationBundle\DataFixtures\PHPCR;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use IPCApplicationBundle\Document\DemoSeoContent;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;
use Symfony\Cmf\Bundle\SeoBundle\Doctrine\Phpcr\SeoMetadata;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class LoadSeoContent implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager|DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contentParent = $manager->find(null, '/cms/content');
        $routeParent = $manager->find(null, '/cms/routes/services');
        $menuBase = $manager->find(null, '/cms/menu/footer');

        $content = new DemoSeoContent();
        $content->setParentDocument($contentParent);
        $content->setName('seo-service');
        $content->setTitle('SEO Service');
        $content->setBody('A page about SEO service');
        $metaData = new SeoMetadata();
        $metaData->setMetaDescription('Description in Metadata');
        $content->setSeoMetadata($metaData);
        $manager->persist($content);


        $contentRoute = new Route();
        $contentRoute->setPosition($routeParent, 'seo-service');
        $contentRoute->setContent($content);
        $manager->persist($contentRoute);

        $menuNode = new MenuNode();
        $menuNode->setParentDocument($menuBase);
        $menuNode->setName('seo-service');
        $menuNode->setLabel('SEO Services');
        $menuNode->setContent($content);
        $manager->persist($menuNode);

        $manager->flush();
    }
}