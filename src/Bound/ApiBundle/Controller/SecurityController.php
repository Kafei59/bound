<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 17:06:33
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-31 17:15:48
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

class SecurityController extends PController {

    /**
     * Mapping [GET] /api/login
     */
    public function loginAction(Request $request) {
        $request = $this->getRequest();
        $username = $request->get('username');
        $password = $request->get('password');
         
        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByUsername($username);
        if (!$user) {
            $user = $um->findUserByEmail($username);
        }

        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        }

        if (!$this->checkUserPassword($user, $password)) {
            throw new HttpException(400, "Wrong credentials.");
        }
         
        $token = $this->get('bound.token_manager')->add($user);
        return array('token' => $token);
    }

    /**
     * Mapping [GET] /api/registration
     */
    public function registrationAction(Request $request) {
        return array();
    }

    private function checkUserPassword(User $user, $password) {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder) {
            return false;
        } else {
            return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        }
    }
}
