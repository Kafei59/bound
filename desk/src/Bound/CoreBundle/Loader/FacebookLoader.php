<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-17 17:10:49
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-22 15:54:50
 */

namespace Bound\CoreBundle\Loader;

use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use Symfony\Component\DependencyInjection\Container;

class FacebookLoader {

    private $container;
    private $responses = array();

    public function __construct(Container $container, Client $client) {
        $this->container = $container;
        $this->getResponses($client);
    }

    public function getResponses(Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();

        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');
        $this->responses['friends'] = $response['summary']['total_count'];
    }

    public function LoadUnknown(Player $player, Client $client) {
        if ($this->responses['friends'] >= 50) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneBySlug("inconnu");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Inconnu' !", "achievement");
            }
        }
    }

    public function LoadCommon(Player $player, Client $client) {
        if ($this->responses['friends'] >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneBySlug("fréquenté");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Fréquenté' !", "achievement");
            }
        }
    }

    public function LoadCheerleader(Player $player, Client $client) {
        if ($this->responses['friends'] >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneBySlug("cheerleader");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Cheerleader' !", "achievement");
            }
        }
    }

    public function LoadStar(Player $player, Client $client) {
        if ($this->responses['friends'] >= 2500) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneBySlug("star");
            if (!array_key_exists($achievement->getId(), $player->getAchievements())) {
                $player->addAchievement($achievement);
                $this->container->get('bound.notification_manager')->add($player, "Haut-Fait débloqué", "Bravo, tu as débloqué le succès 'Star' !", "achievement");
            }
        }
    }
}
