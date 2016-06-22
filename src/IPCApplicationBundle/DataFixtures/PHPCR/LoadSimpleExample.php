<?php

namespace IPCApplicationBundle\DataFixtures\PHPCR;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ODM\PHPCR\DocumentManager;
use Nelmio\Alice\Fixtures;
use Symfony\Cmf\Bundle\MenuBundle\Doctrine\Phpcr\MenuNode;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class LoadSimpleExample implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager|DocumentManager $manager
     */
    public function load(ObjectManager $manager)
    {

        if (!$manager instanceof DocumentManager) {
            $class = get_class($manager);
            throw new \RuntimeException("Fixture requires a PHPCR ODM DocumentManager instance, instance of '$class' given.");
        }
        // tweak homepage
        $page = $manager->find(null, '/cms/simple');
        $page->setBody('Hello');
        $page->setDefault('_template', 'IPCApplicationBundle::home.html.twig');
        // add menu item for home
        $menuRoot = $manager->find(null, '/cms/simple');
        $homeMenuNode = new MenuNode('home');
        $homeMenuNode->setLabel('Home');
        $homeMenuNode->setParentDocument($menuRoot);
        $homeMenuNode->setContent($page);
        $manager->persist($homeMenuNode);
        // load the pages
        Fixtures::load(array(__DIR__.'/../../Resources/data/pages.yml'), $manager);

        // save the changes
        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
