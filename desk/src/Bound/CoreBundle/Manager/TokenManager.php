<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 16:48:01
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-16 09:38:44
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\UserBundle\Util\TokenGenerator;

class TokenManager extends PManager {

    public function add($user) {
        $tg = new TokenGenerator();
        $token = new Token();

        $token->setData($tg->generateToken());
        $token->setUser($user);
        $token->setDate(new \Datetime('now'));

        $this->pflush($token);

        return $token;
    }
};
