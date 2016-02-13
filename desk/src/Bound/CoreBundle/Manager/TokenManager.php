<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 16:48:01
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-11 20:47:30
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;
use FOS\UserBundle\Util\TokenGenerator;

class TokenManager extends PManager {

    public function add($username, $password) {
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

        $tg = new TokenGenerator();
        $token = new Token();

        $token->setData($tg->generateToken());
        $token->setUser($user);
        $token->setDate(new \Datetime('now'));

        $this->pflush($token);

        return $token;
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
};
