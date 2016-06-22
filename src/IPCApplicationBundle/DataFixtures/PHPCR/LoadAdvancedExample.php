<?php

namespace IPCApplicationBundle\DataFixtures\PHPCR;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use Symfony\Cmf\Bundle\ContentBundle\Doctrine\Phpcr\StaticContent;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\Menu;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class LoadAdvancedExample implements FixtureInterface, OrderedFixtureInterface
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

        $enRoute = new Route();
        $enRoute->setPosition($routeParent, 'en');
        $manager->persist($enRoute);
        $deRoute = new Route();
        $deRoute->setPosition($routeParent, 'de');
        $manager->persist($deRoute);

        $enServiceRoute = new Route();
        $enServiceRoute->setPosition($enRoute, 'services');
        $manager->persist($enServiceRoute);
        $deServiceRoute = new Route();
        $deServiceRoute->setPosition($deRoute, 'dienstleistungen');
        $manager->persist($deServiceRoute);

        $content = new StaticContent();
        $content->setParentDocument($contentParent);
        $content->setName('symfony-service');
        $manager->persist($content);


        $content->setTitle('Symfony Service');
        $content->setBody('A page about Symfony service');
        $manager->bindTranslation($content, 'en');
        $contentRoute = new Route();
        $contentRoute->setPosition($enServiceRoute, 'symfony-service');
        $contentRoute->setContent($content);
        $manager->persist($contentRoute);

        $content->setTitle('Symfony Dienstleistungen');
        $content->setBody('Eine Seite über Symfony Dienstleistungen');
        $manager->bindTranslation($content, 'de');
        $contentRoute = new Route();
        $contentRoute->setPosition($deServiceRoute, 'symfony-dienstleistungen');
        $contentRoute->setContent($content);
        $manager->persist($contentRoute);

        $menu = new Menu();
        $menu->setPosition($menuBase, 'footer');
        $manager->persist($menu);

        $menuNode = new MenuNode();
        $menuNode->setParentDocument($menu);
        $menuNode->setContent($content);
        $menuNode->setName('symfony-service');
        $manager->persist($menuNode);

        $menuNode->setLabel('Symfony Services');
        $manager->bindTranslation($menuNode, 'en');
        $menuNode->setLabel('Symfony Dienstleistungen');
        $manager->bindTranslation($menuNode, 'de');

        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
