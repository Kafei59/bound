<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\UserBundle\Entity\User;

class UserController extends Controller {

    public function allAction() {
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


    /**
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     */
    public function getAction(User $user) {
        $response = new JsonResponse($user->toArray(), 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }

    /**
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     */
    public function friendsAction(User $user) {
        $entities = $this->getDoctrine()->getRepository('BoundUserBundle:User')->findBy(array('username' => $user->getFriends()));

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
