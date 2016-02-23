<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-23 12:24:48
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 12:28:05
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\Notification;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NofiticationTest extends PTest {

    public function testAdd() {
        $user = $this->container->get('bound.user_manager')->add("lololol", "loololol@mail.com", "lololol");

        /* Not failing */
        $this->notAssert($user);
    }

    private function assert($user) {
        try {
            $this->container->get('bound.notification_manager')->add($user->getPlayer(), "title", "content", "type");
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssert($user) {
        try {
            $this->container->get('bound.notification_manager')->add($user->getPlayer(), "title", "content", "type");
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }
}
