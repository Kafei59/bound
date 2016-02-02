<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-10 14:22:52
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-02 16:43:55
 */

namespace Bound\CoreBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

use Bound\CoreBundle\DataFixtures\ORM\LoadAchievementData;

class PTest extends WebTestCase {

    protected $container;
    protected $manager;

    public function __construct() {
        $client = static::createClient();
        $this->container = $client->getContainer();
        $this->manager = $client->getContainer()->get('doctrine')->getManager();
    }

    public function testContainer() {
        $this->assertNotNull($this->container);
    }

    private function loadFixtures() {
        $loader = new Loader();
        $loader->addFixture(new LoadAchievementData());
        
        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->manager, $purger);
        $executor->execute($loader->getFixtures());
    }
}
