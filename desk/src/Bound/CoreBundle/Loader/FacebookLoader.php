<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-17 17:10:49
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-18 12:00:57
 */

namespace Bound\CoreBundle\Loader;

class FacebookLoader {

    public function unknownLoader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 50) {
            $player->addAchievement($achievement);
        }
    }

    public function commonLoader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 300) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Fréquenté");
            $player->addAchievement($achievement);
        }
    }

    public function cheerleaderLoader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];

        if ($friends >= 1000) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Cheerleader");
            $player->addAchievement($achievement);
        }
    }

    public function starLoader(Player $player, Client $client) {
        $url = 'https://graph.facebook.com/'.$client->getFacebookId().'/friends/?access_token='.$client->getFacebookAccessToken();
        $response = $this->container->get('bound.curl_listener')->get($url, 'Get Facebook Datas');

        $friends = $response['summary']['total_count'];
        
        if ($friends >= 2500) {
            $achievement = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Achievement')->findOneByTitle("Star");
            $player->addAchievement($achievement);
        }
    }
}
