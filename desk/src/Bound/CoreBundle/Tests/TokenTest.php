<?php
/**
 * @Author: gicque_p
 * @Date:   2016-01-27 17:53:36
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 15:31:36
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\Token;
use Bound\CoreBundle\Manager\TokenManager;

use Symfony\Component\HttpKernel\Exception\HttpException;

class TokenTest extends PTest {

    public function testAdd() {
        /* Username doesn't exists */
        $this->assert("titi", "tutu");

        /* Wrong password */
        $this->assert("Kafei", "lol");

        /* Not failing */
        $this->notAssert("Kafei", "toto");
    }

    private function assert($username, $password) {
        try {
            $this->container->get('bound.token_manager')->add($username, $password);
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssert($username, $password) {
        try {
            $this->container->get('bound.token_manager')->add($username, $password);
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}
