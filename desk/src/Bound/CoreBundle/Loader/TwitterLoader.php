<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-22 15:55:16
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-23 10:22:15
 */

namespace Bound\CoreBundle\Loader;

use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use Symfony\Component\DependencyInjection\Container;

class TwitterLoader {

    private $container;
    private $responses = array();

    public function __construct(Container $container, Client $client) {
        $this->container = $container;
        $this->getResponses($client);
    }

    public function getResponses(Client $client) {
        $url = 'https://api.twitter.com/1.1/users/show.json';

        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Twitter Profile', array(
            'resource' => "twitter", 
            'request' => array('user_id' => $client->getTwitterId())
        ));

        $this->responses['followers'] = $response['followers_count'];
    }

    public function loadLittleChick(Player $player, Client $client) {
        if ($this->responses['followers'] >= 50) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneBySlug("petit+poussin");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Petit poussin' !", "achievement");
            }
        }
    }

    // NUMBER OF FOLLOWERS, OF TWEETS, OF FAVORITES, FOLLOWED BY ME, FOLLOWING ME, CREATED FROM, IS CONTRIBUTOR, IS TRANSLATOR, LOCATED ?
}
