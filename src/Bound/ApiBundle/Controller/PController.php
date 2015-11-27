<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-27 17:20:28
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-11-27 17:28:55
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PController extends Controller {

    public function jsonEntitiesResponse($entities) {
        $data = array();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $data[$entity->getId()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($data, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }

    public function jsonEntityResponse($entity) {
        $response = new JsonResponse($entity->toArray(), 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;        
    }
}
