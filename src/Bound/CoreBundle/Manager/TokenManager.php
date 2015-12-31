<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 16:48:01
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-31 16:52:03
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;

class TokenManager extends PManager {

    public function add(User $user) {
        $token = new Token();

        $token->setData(bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)));
        $token->setUser($user);
        $token->setDate(new \Datetime('now'));

        $this->pflush($token);
    }
};
