<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\User;

class UserController extends PController {

    public function allAction() {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

        return $this->jsonEntitiesResponse($entities);
    }


    /**
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     */
    public function getAction(User $user) {
        return $this->jsonEntityResponse($user);
    }

    /**
     * @ParamConverter("user", options={"mapping": {"username": "username"}})
     */
    public function friendsAction(User $user) {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findBy(array('username' => $user->getFriends()));

        return $this->jsonEntitiesResponse($entities);
    }
}
