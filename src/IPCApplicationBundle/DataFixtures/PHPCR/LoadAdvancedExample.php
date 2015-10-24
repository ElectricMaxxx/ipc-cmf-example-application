<?php

namespace IPCApplicationBundle\DataFixtures\PHPCR;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class LoadAdvancedExample implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager|DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contentParent = $manager->find(null, '/cms/content');
        $routeParent = $manager->find(null, '/cms/routes');
        $menuBase = $manager->find(null, '/cms/menu');

        $serviceRoute = new Route();
        $serviceRoute->setPosition($routeParent, 'services');
        $manager->persist($serviceRoute);

        $content = new StaticContent();
        $content->setParentDocument($contentParent);
        $content->setName('symfony-service');
        $content->setTitle('Symfony Service');
        $content->setBody('A page about Symfony service');
        $manager->persist($content);

        $contentRoute = new Route();
        $contentRoute->setPosition($serviceRoute, 'symfony-service');
        $contentRoute->setContent($content);
        $manager->persist($contentRoute);

        $menu = new Menu();
        $menu->setPosition($menuBase, 'footer');
        $manager->persist($menu);

        $menuNode = new MenuNode();
        $menuNode->setParentDocument($menu);
        $menuNode->setName('symfony-service');
        $menuNode->setLabel('Symfony Services');
        $menuNode->setContent($content);
        $manager->persist($menuNode);

        $manager->flush();
    }
}
