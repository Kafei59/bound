<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\User;

class UserController extends PController {

    /**
     * Mapping [GET] /api/users
     */
    public function getUsersAction() {
        $users = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

        return array('users' => $users);
    }

    /**
     * Mapping [GET] /api/users/{user}
     * @ParamConverter("user", options={"mapping": {"user": "username"}})
     */
    public function getUserAction(User $user) {
        return array('user' => $user);
    }
}
