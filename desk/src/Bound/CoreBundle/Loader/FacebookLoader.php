<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-17 17:10:49
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-26 01:10:00
 */

namespace Bound\CoreBundle\Loader;

use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use Symfony\Component\DependencyInjection\Container;

class FacebookLoader {

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function LoadUnknown(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 50) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Inconnu");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Inconnu' !", "achievement");
            }
        }
    }

    public function LoadCommon(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Fréquenté");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Fréquenté' !", "achievement");
            }
        }
    }

    public function LoadCheerleader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Cheerleader");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Cheerleader' !", "achievement");
            }
        }
    }

    public function LoadStar(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 2500) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Star");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Star' !", "achievement");
            }
        }
    }
}
