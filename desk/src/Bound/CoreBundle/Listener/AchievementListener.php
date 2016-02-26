<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-17 16:58:32
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-26 01:11:24
 */

namespace Bound\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

class AchievementListener {

    protected $container;

    public function __construct(Container $container, EntityManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }

    public function loadAll(User $user) {
        $player = $user->getPlayer();
        $client = $user->getClient();
        $achievements = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findAll();

        if ($client instanceof Client) {        
            foreach ($achievements as $achievement) {
                $this->load($achievement, $player, $client);
            }

            $this->manager->persist($player);
            $this->manager->flush();
        }

        return $player;
    }

    public function loadType(User $user, $type) {
        $player = $user->getPlayer();
        $client = $user->getClient();
        $achievements = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findByType($type);

        if ($client instanceof Client) {        
            foreach ($achievements as $achievement) {
                $this->load($achievement, $player, $client);
            }

            $this->manager->persist($player);
            $this->manager->flush();
        }

        return $player;
    }

    public function loadFunction($functionId) {
        $player = $user->getPlayer();
        $client = $user->getClient();

        if ($client instanceof Client) {        
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId($functionId);
            $this->load($achievement, $player, $client);

            $this->manager->persist($player);
            $this->manager->flush();
        }

        return $player;
    }

    private function load($achievement, Player $player, Client $client) {
        if ($achievement->getType() != NULL and $achievement->getFunctionId() != NULL) {
            $type = 'Bound\CoreBundle\Loader\\'.ucfirst($achievement->getType())."Loader";
            $function = "Load".ucfirst($achievement->getFunctionId());

            if (class_exists($type)) {
                $loader = new $type($this->container);

                if (method_exists($loader, $function)) {
                    $loader->$function($player, $client);
                }
            }
        }
    }
}
