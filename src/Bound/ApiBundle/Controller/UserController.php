<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller {

    public function getAction(Request $request) {
        $entities = $this->getDoctrine()->getRepository('BoundUserBundle:User')->findAll();

        $users = array();
        if (!empty($entities)) {        
            foreach ($entities as $entity) {
                $users[$entity->getSalt()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($users, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }
}
