<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 17:06:33
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-27 17:52:38
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

use FOS\RestBundle\Controller\Annotations\Post;

class SecurityController extends PController {

    /**
     * Mapping [POST] /api/login
     * @Post("/login")
     */
    public function loginAction(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');
 
        $token = $this->get('bound.token_manager')->add($username, $password);
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
}
