<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-16 14:03:56
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-16 17:55:28
 */

namespace Bound\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Client;
use Bound\CoreBundle\Entity\Player;

class FacebookListener {

    protected $container;

    public function __construct(Container $container, EntityManager $manager) {
        $this->container = $container;
        $this->manager = $manager;
    }

    public function launch($user) {
        $client = $user->getClient();
        $player = $user->getPlayer();

        $response = array();
        if ($client instanceof Client) {
            if ($client->getFacebookId() and $client->getFacebookAccessToken()) {
                $this->loadFriends($client, $player);
            }
        }
    }

    private function loadFriends(Client $client, Player $player) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 50) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Inconnu");
            $player->addAchievement($achievement);
        }

        if ($friends >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Fréquenté");
            $player->addAchievement($achievement);
        }

        if ($friends >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Cheerleader");
            $player->addAchievement($achievement);
        }

        if ($friends >= 2500) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Star");
            $player->addAchievement($achievement);
        }

        $this->manager->persist($player);
        $this->manager->flush();
    }
}
