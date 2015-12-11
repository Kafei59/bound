<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-10 14:22:52
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-11 10:01:48
 */

namespace Bound\CoreBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

class PTest extends WebTestCase {

    protected $container;

    public function __construct() {
        $client = static::createClient();
        $this->container = $client->getContainer();
    }

    public function testContainer() {
        $this->assertNotNull($this->container);
    }
}
