<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 16:48:01
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 11:29:09
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\AManager;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\UserBundle\Util\TokenGenerator;

class TokenManager extends AManager {

    public function add($user) {
        $tg = new TokenGenerator();
        $token = new Token();

        $token->setData($tg->generateToken());
        $token->setUser($user);
        $token->setDate(new \Datetime('now'));

        $this->pflush($token);

        return $token;
    }

    public function edit(Token $token) {
        $this->pflush($token);

        return $token;
    }

    public function delete(Token $token) {
        $this->rflush($token);
    }
};
