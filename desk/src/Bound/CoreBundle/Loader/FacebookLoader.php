<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-17 17:10:49
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 12:21:53
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
            $player->addAchievement($achievement);
            $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Inconnu' !", "facebook");
        }
    }

    public function LoadCommon(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Fréquenté");
            $player->addAchievement($achievement);
            $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Fréquenté' !", "facebook");
        }
    }

    public function LoadCheerleader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Cheerleader");
            $player->addAchievement($achievement);
            $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Cheerleader' !", "facebook");
        }
    }

    public function LoadStar(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 2500) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Star");
            $player->addAchievement($achievement);
            $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Star' !", "facebook");
        }
    }
}
