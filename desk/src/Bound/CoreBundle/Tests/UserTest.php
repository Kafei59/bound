<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-04 16:16:29
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 17:56:50
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

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
        $id = uniqid();
        $this->notAssert($id, $id."@mail.com", "toto", self::ADD);

        /* Checking if relationship is well persist */
        $user = $this->container->get('doctrine')->getRepository('BoundCoreBundle:User')->findOneByUsername($id);

        $this->assertNotNull($user);

        $player = $user->getPlayer();
        $client = $user->getClient();

        $this->assertNotNull($player);
        $this->assertNotNull($client);
        $this->assertNotNull($player->getOwner());
        $this->assertNotNull($client->getOwner());

        $this->assertEquals($player->getOwner()->getId(), $user->getId());
        $this->assertEquals($client->getOwner()->getId(), $user->getId());
    }

    public function testDelete() {
        /* Not failing */
        $id = uniqid();
        $this->notAssert($id, $id."@mail.com", "toto", self::ADD);

        /* Checking if player and client are deleted when user is deleted */
        $user = $this->container->get('doctrine')->getRepository('BoundCoreBundle:User')->findOneByUsername($id);

        $this->assertNotNull($user);

        $player = $user->getPlayer();
        $client = $user->getClient();

        $this->assertNotNull($player);
        $this->assertNotNull($client);

        $this->assertNotEquals(0, $user->getId());
        $this->assertNotEquals(0, $player->getId());
        $this->assertNotEquals(0, $client->getId());

        $this->container->get('bound.user_manager')->delete($user);

        $this->assertEquals(0, $user->getId());
        $this->assertEquals(0, $player->getId());
        $this->assertEquals(0, $client->getId());
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
