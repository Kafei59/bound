<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-16 14:10:41
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-23 10:13:26
 */

namespace Bound\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;
use Bound\CoreBundle\Utils\CurlUtils;

class CurlListener {

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function get($url, $agent, $options = array()) {
        if (array_key_exists('resource', $options) and $options['resource'] == 'twitter') {
            $resource = $this->getTwitterResource($url, $options);

            $header = $resource['header'];
            $url = $resource['url'];
        } else {
            $header = array('Content-Type: application/json', 'Accept: application/json');
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => $agent
        ));

        $response = json_decode(curl_exec($curl), true);
        curl_close($curl);

        return $response;
    }

    private function getTwitterResource($url, $options) {
        $consumer_key = $this->container->getParameter('twitter_consumer_key');
        $consumer_secret = $this->container->getParameter('twitter_consumer_secret');
        $oauth_access_token = $this->container->getParameter('twitter_access_token');
        $oauth_access_token_secret = $this->container->getParameter('twitter_access_token_secret');

        $oauth = array(
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );

        $rurl = $url;
        if (array_key_exists('request', $options)) {
            $rurl .= '?';
            foreach ($options['request'] as $key => $request) {
                $oauth[$key] = $request;
                $rurl .= $key."=".$request;
            }
        }

        $base_info = CurlUtils::buildBaseString($url, 'GET', $oauth);
        $composite_key = rawurlencode($consumer_secret).'&'.rawurlencode($oauth_access_token_secret);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        return array(
            'url' => $rurl,
            'header' => array(CurlUtils::buildAuthorizationHeader($oauth), 'Expect:')
        );
    }
}
