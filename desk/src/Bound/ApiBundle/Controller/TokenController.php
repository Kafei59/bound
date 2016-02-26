<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-25 17:16:50
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-26 10:38:06
 */


namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use FOS\RestBundle\Controller\Annotations\Post;

class TokenController extends AController {
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
}
