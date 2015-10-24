<?php

namespace IPCApplicationBundle\DataFixtures\PHPCR;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use PHPCR\Util\NodeHelper;
use Symfony\Cmf\Bundle\RoutingBundle\Doctrine\Phpcr\Route;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class LoadRoutesOnly implements  FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager|DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {
        NodeHelper::createPath($manager->getPhpcrSession(), '/cms/routes');

        $routeBase = $manager->find(null, '/cms/routes');

        $route = new Route();
        $route->setPosition($routeBase, 'route_only');
        $route->addDefaults(['_controller' => 'ipc_application.controller.default:routeOnlyAction']);

        $manager->persist($route);
        $manager->flush();
    }
}
