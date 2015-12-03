<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:26:09
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-03 12:30:38
 */

namespace Bound\CoreBundle\Manager;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

class PManager {

    protected $container;
    protected $manager;

    public function __construct(Container $container, EntityManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }

    public function persist($object) {
        $this->manager->persist($object);
    }

    public function remove($object) {
        $this->manager->remove($object);
    }

    public function flush() {
        $this->manager->flush();
    }

    public function pflush($object) {
        $this->persist($object);
        $this->flush();
    }

    public function rflush($object) {
        $this->remove($object);
        $this->flush();
    }
};
