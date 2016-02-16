<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 17:06:33
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-16 16:30:39
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use FOS\RestBundle\Controller\Annotations\Post;

class SecurityController extends PController {

    /**
     * Mapping [POST] /api/login
     * @Post("/login")
     */
    public function loginAction(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');

        $fum = $this->container->get('fos_user.user_manager');
        $user = $fum->findUserByUsername($username);

        if (!$user) {
            $user = $fum->findUserByEmail($username);
        }

        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        }

        if (!$this->checkUserPassword($user, $password)) {
            throw new HttpException(403, "Wrong credentials.");
        }

        if (!$user->isEnabled()) {
            throw new HttpException(403, "Email not checked.");
        }

        $token = $this->getDoctrine()->getRepository('BoundCoreBundle:Token')->findOneByUser($user);
        if (!$token) {
            $token = $this->get('bound.token_manager')->add($user);
        }

        return array('token' => $token);
    }

    /**
     * Mapping [POST] /api/register
     * @Post("/register")
     */
    public function registerAction(Request $request) {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($username and $email and $password) {
            $this->get('bound.user_manager')->add($username, $email, $password);

            return array("Email sent to ".$email.".");
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }

    /**
     * Mapping [POST] /api/resetting
     * @Post("/resetting")
     */
    public function resettingAction(Request $request) {
        $email = $request->get('email');

        if ($email) {
            $this->get('bound.user_manager')->changePassword($email);

            return array("Email sent to ".$email.".");
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }

    /**
     * Mapping [POST] /api/token
     * @Post("/token")
     */
    public function tokenAction(Request $request) {
        $token = $request->get('token');

        if ($token) {
            $user = $this->assertToken($token);

            return $user;
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }


    private function checkUserPassword(User $user, $password) {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder) {
            return false;
        } else {
            return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        }
    }
}
