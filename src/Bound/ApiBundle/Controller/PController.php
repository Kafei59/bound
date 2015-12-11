<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-27 17:20:28
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-11 10:10:59
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
            $status = 400;
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

    public function assertRequestMethod(Request $request, $method) {
        if (!$request->isMethod($method)) {
            throw new HttpException(400, "Bad Request.");
        }
    }

    public function createJsonReponse($content) {
        $serializer = $this->get('jms_serializer');
        $json = $serializer->serialize($content, 'json');

        $response = new JsonResponse($json, 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }

    public function createEntityFromContent($content, $entityName) {
        $serializer = $this->get('jms_serializer');
        $entity = $serializer->deserialize($content, $entityName, 'json');

        return $entity;
    }
}
