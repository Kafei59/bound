<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AchievementController extends Controller {

    public function allAction(Request $request) {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        $achievements = array();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $achievements[$entity->getId()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($achievements, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }
}
