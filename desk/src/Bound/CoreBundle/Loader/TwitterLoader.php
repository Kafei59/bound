<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-22 15:55:16
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-23 17:02:16
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
        $this->responses['favourites'] = $response['favourites_count'];
    }

    public function loadLittleChick(Player $player) {
        if ($this->responses['followers'] >= 50) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId("littleChick");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Petit poussin' !", "achievement");
            }
        }
    }

    public function loadJunior(Player $player) {
        if ($this->responses['followers'] >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId("junior");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Junior' !", "achievement");
            }
        }
    }

    public function loadSenior(Player $player) {
        if ($this->responses['followers'] >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId("senior");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Senior' !", "achievement");
            }
        }
    }

    public function loadStopDude(Player $player) {
        if ($this->responses['followers'] >= 150000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId("stopDude");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Stop Dude' !", "achievement");
            }
        }
    }

    public function loadFan(Player $player) {
        if ($this->responses['favourites'] >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByFunctionId("fan");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Je suis fan' !", "achievement");
            }
        }
    }


    // NUMBER OF FOLLOWERS, OF TWEETS, OF FAVORITES, FOLLOWED BY ME, FOLLOWING ME, CREATED FROM, IS CONTRIBUTOR, IS TRANSLATOR, LOCATED ?
}
