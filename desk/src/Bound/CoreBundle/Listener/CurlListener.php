<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-16 14:10:41
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-16 17:07:43
 */

namespace Bound\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;

class CurlListener {

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function get($url, $agent) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => $agent,
            CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json'
            )
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $response;
    }
}
