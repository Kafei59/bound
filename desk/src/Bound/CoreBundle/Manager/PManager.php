<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:26:09
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-04 10:30:27
 */

namespace Bound\CoreBundle\Manager;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PManager {

    protected $container;
    protected $manager;
    protected $provider;
    protected $storage;
    protected $um;

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
