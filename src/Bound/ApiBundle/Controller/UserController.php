<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    public function getAction(Request $request) {
        $resp = array();
        $entities = $this->getDoctrine()->getRepository('BoundUserBundle:User')->findAll();

        if (!empty($entities)) {        
            $users = array();
            foreach ($entities as $entity) {
                $users[$entity->getSalt()] = $entity->toArray();
            }

            $resp['response'] = 200;
            $resp['users'] = $users;
        } else {
            $resp['response'] = 500;
        }

        $response = new Response(json_encode($resp, JSON_PRETTY_PRINT));
        $response->headers->set('Content-Type', "application/json");

        return $response;
    }
}
