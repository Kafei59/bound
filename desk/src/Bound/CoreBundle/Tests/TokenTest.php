<?php
/**
 * @Author: gicque_p
 * @Date:   2016-01-27 17:53:36
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-16 11:11:45
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Manager\TokenManager;

use Symfony\Component\HttpKernel\Exception\HttpException;

class TokenTest extends PTest {

    public function testAdd() {
        $user = $this->container->get('bound.user_manager')->add("lol", "lool@mail.com", "lol");

        /* Not failing */
        $this->notAssert($user);
    }

    private function assert($user) {
        try {
            $this->container->get('bound.token_manager')->add($user);
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssert($user) {
        try {
            $this->container->get('bound.token_manager')->add($user);
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}
