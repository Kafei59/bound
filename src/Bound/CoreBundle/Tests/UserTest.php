<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-04 16:16:29
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-28 09:38:27
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Symfony\Component\HttpKernel\Exception\HttpException;

class UserTest extends PTest {

    const ADD = "add";
    const PASS = "pass";

    public function testAdd() {
        /* Username already exists */
        $this->assert("Kafei", "lolol@mail.com", "toto", self::ADD);

        /* Email already exists */
        $this->assert("Kafei123456", "toto@mail.com", "toto", self::ADD);

        /* Not failing */
        $this->notAssert(uniqid(), uniqid()."@mail.com", "toto", self::ADD);
    }

    public function testChangePassword() {
        /* Email doesn't exists */
        $this->assert(NULL, uniqid()."@mail.com", NULL, self::PASS);

        /* Not failing */
        $this->notAssert(NULL, "toto@mail.com", NULL, self::PASS);

        /* Already Requested */
        $this->assert(NULL, "toto@mail.com", NULL, self::PASS);
    }

    private function assert($username, $email, $password, $method) {
        try {
            switch ($method) {
                case self::ADD:
                    $this->container->get('bound.user_manager')->add($username, $email, $password);
                    break;
                case self::PASS:
                    $this->container->get('bound.user_manager')->changePassword($email);
                    break;
            }
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssert($username, $email, $password, $method) {
        try {
            switch ($method) {
                case self::ADD:
                    $this->container->get('bound.user_manager')->add($username, $email, $password);
                    break;
                case self::PASS:
                    $this->container->get('bound.user_manager')->changePassword($email);
                    break;
            }
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}
