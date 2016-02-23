<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\User;

class UserController extends AController {

    /**
     * Mapping [GET] /api/users
     */
    public function getUsersAction(Request $request) {
        $this->assertToken($request->get('token'));
        $users = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

        return array('users' => $users);
    }

    /**
     * Mapping [GET] /api/users/{user}
     * @ParamConverter("user", options={"mapping": {"user": "username"}})
     */
    public function getUserAction(User $user, Request $request) {
        $this->assertToken($request->get('token'));

        return array('user' => $user);
    }
}
