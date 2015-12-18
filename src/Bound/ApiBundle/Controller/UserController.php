<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;

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

    /**
     * Mapping [POST] /api/users
     */
    public function postUserAction(Request $request) {
        $user = $this->getUser();

        $registration = $this->container->get('fos_user.registration.form');
        $registrationHandler = $this->container->get('fos_user.registration.form.handler');
        $process = $registrationHandler->process($user);

        $this->authenticateUser($request, array(), 200);
        // var_dump($registrationHandler);
        if ($process) {
            var_dump("toto");
        }

        return array();
    }

    // public function allAction() {
    //     $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

    //     return $this->jsonEntitiesResponse($entities);
    // }


    // /**
    //  * @ParamConverter("user", options={"mapping": {"username": "username"}})
    //  */
    // public function getAction(User $user) {
    //     return $this->jsonEntityResponse($user);
    // }

    // /**
    //  * @ParamConverter("user", options={"mapping": {"username": "username"}})
    //  */
    // public function friendsAction(User $user) {
    //     $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findBy(array('username' => $user->getFriends()));

    //     return $this->jsonEntitiesResponse($entities);
    // }

    // public function loginAction(Request $request) {
    //     $session = $request->getSession();
    //     if (class_exists('\Symfony\Component\Security\Core\Security')) {
    //         $authErrorKey = Security::AUTHENTICATION_ERROR;
    //         $lastUsernameKey = Security::LAST_USERNAME;
    //     } else {
    //         // BC for SF < 2.6
    //         $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
    //         $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
    //     }
    //     // get the error if any (works with forward and redirect -- see below)
    //     if ($request->attributes->has($authErrorKey)) {
    //         $error = $request->attributes->get($authErrorKey);
    //     } elseif (null !== $session && $session->has($authErrorKey)) {
    //         $error = $session->get($authErrorKey);
    //         $session->remove($authErrorKey);
    //     } else {
    //         $error = null;
    //     }
    //     if (!$error instanceof AuthenticationException) {
    //         $error = null; // The value does not come from the security component.
    //     }
    //     // last username entered by the user
    //     $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
    //     if ($this->has('security.csrf.token_manager')) {
    //         $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
    //     } else {
    //         // BC for SF < 2.4
    //         $csrfToken = $this->has('form.csrf_provider') ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;
    //     }

    //     $user = $this->getUser();

    //     var_dump($user);
    //     return $this->jsonEntityResponse($user);
    // }
}
