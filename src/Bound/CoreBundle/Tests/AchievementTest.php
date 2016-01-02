<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-04 16:15:55
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-02 16:44:10
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Manager\AchievementManager;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AchievementTest extends PTest {

    const ADD = "add";
    const EDIT = "edit";
    const DELETE = "delete";

    public function testAdd() {
        $notAdmin = new User();
        $admin = $this->manager->getRepository('BoundCoreBundle:User')->findOneBy(array('username' => "Kafei"));

        /* ID failure */
        $achievement1 = new Achievement();
        $achievement1->setId(1);
        $achievement1->setTitle("Title");
        $achievement1->setContent("Content");
        $achievement1->setPoints(10);

        /* Access Denied */
        $achievement2 = new Achievement();
        $achievement2->setTitle(uniqid());
        $achievement2->setContent("Content");
        $achievement2->setPoints(10);

        /* Not failing */
        $achievement3 = new Achievement();
        $achievement3->setTitle(uniqid());
        $achievement3->setContent("Content");
        $achievement3->setPoints(10);

        /* No points set */
        $achievement4 = new Achievement();
        $achievement4->setTitle("Title");
        $achievement4->setContent("Content");

        /* Title already exists */
        $achievement5 = new Achievement();
        $achievement5->setTitle("Globetrotter");
        $achievement5->setContent("Content");
        $achievement5->setPoints(10);

        $this->assert($achievement1, $notAdmin, self::ADD);
        $this->assert($achievement2, $notAdmin, self::ADD);
        $this->notAssert($achievement3, $admin, self::ADD);
        $this->assert($achievement3, $notAdmin, self::ADD);
        $this->assert($achievement4, $notAdmin, self::ADD);
    }

    public function testEdit() {
        $notAdmin = new User();
        $admin = $this->manager->getRepository('BoundCoreBundle:User')->findOneBy(array('username' => "Kafei"));
        $achievement = $this->manager->getRepository('BoundCoreBundle:Achievement')->findOneBy(array('title' => "Globetrotter"));

        /* Access Denied */
        $this->assert($achievement, $notAdmin, self::EDIT);

        /* Not failing */
        $this->notAssert($achievement, $admin, self::EDIT);
    }

    public function testDelete() {
        $notAdmin = new User();
        $admin = $this->manager->getRepository('BoundCoreBundle:User')->findOneBy(array('username' => "Kafei"));

        $achievement = new Achievement();
        $achievement->setTitle(uniqid());
        $achievement->setContent("Content");
        $achievement->setPoints(10);

        $this->container->get('bound.achievement_manager')->add($achievement, $admin);

        /* Access Denied */
        $this->assert($achievement, $notAdmin, self::DELETE);

        /* Not failing */
        $this->notAssert($achievement, $admin, self::DELETE);
    }

    private function assert(Achievement $achievement, User $user, $method) {
        try {
            switch ($method) {
                case self::ADD:
                    $this->container->get('bound.achievement_manager')->add($achievement, $user);
                    break;
                case self::EDIT:
                    $this->container->get('bound.achievement_manager')->edit($achievement, $achievement, $user);
                    break;
                case self::DELETE:
                    $this->container->get('bound.achievement_manager')->delete($achievement, $user);
                    break;
            }
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssert(Achievement $achievement, User $user, $method) {
        try {
            switch ($method) {
                case self::ADD:
                    $this->container->get('bound.achievement_manager')->add($achievement, $user);
                    break;
                case self::EDIT:
                    $this->container->get('bound.achievement_manager')->edit($achievement, $achievement, $user);
                    break;
                case self::DELETE:
                    $this->container->get('bound.achievement_manager')->delete($achievement, $user);
                    break;
            }
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }

}
