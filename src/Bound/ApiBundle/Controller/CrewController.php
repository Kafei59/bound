<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CrewController extends Controller {

    public function allAction(Request $request) {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        $crews = array();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $crews[$entity->getId()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($crews, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }
}
