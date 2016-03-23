<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-22 16:35:36
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-22 16:36:56
 */

namespace Bound\CoreBundle\Utils;

class CurlUtils {

    public static function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $r[] = "$key=".rawurlencode($value);
        }

        return $method."&".rawurlencode($baseURI).'&'.rawurlencode(implode('&', $r));
    }

    public static function buildAuthorizationHeader($oauth) {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach ($oauth as $key => $value) {
            $values[] = "$key=\"".rawurlencode($value)."\"";
        }

        $r .= implode(', ', $values);
        return $r;
    }
}
