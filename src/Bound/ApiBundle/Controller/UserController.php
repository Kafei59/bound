<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

    public function getAction(Request $request) {
        $entities = $this->getDoctrine()->getRepository('BoundUserBundle:User')->findAll();

        $users = array();
        foreach ($entities as $entity) {
            $users[$entity->getSalt()] = $entity->toArray();
        }

        $response = new Response(json_encode($users, JSON_PRETTY_PRINT));
        $response->headers->set('Content-Type', "application/json");

        return $response;
    }
}
