<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-04 16:15:55
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-10 17:44:16
 */

namespace Bound\CoreBundle\Tests;

use Bound\CoreBundle\Tests\PTest;

use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Manager\AchievementManager;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AchievementTest extends PTest {

    private function assertAdd(Achievement $achievement) {
        try {
            $this->container->get('bound.achievement_manager')->add($achievement);
        } catch (HttpException $e) {
            return ;
        } catch (\Exception $e) {
            return ;
        }

        $this->fail();
    }

    private function notAssertAdd(Achievement $achievement) {
        try {
            $this->container->get('bound.achievement_manager')->add($achievement);
        } catch (HttpException $e) {
            $this->fail();
        } catch (\Exception $e) {
            $this->fail();
        }
    }

    public function testAdd() {
        $achievement1 = new Achievement();
        $achievement1->setId(1);
        $achievement1->setTitle("Title");
        $achievement1->setContent("Content");
        $achievement1->setPoints(10);

        $achievement2 = new Achievement();
        $achievement2->setTitle("Globetrotter");
        $achievement2->setContent("Content");
        $achievement2->setPoints(10);

        $achievement3 = new Achievement();
        $achievement3->setTitle(uniqid());
        $achievement3->setContent("Content");
        $achievement3->setPoints(10);

        $achievement4 = new Achievement();
        $achievement4->setTitle("Title");
        $achievement4->setContent("Content");

        $this->assertAdd($achievement1);
        $this->assertAdd($achievement2);
        $this->notAssertAdd($achievement3);
        $this->assertAdd($achievement4);
    }
}
