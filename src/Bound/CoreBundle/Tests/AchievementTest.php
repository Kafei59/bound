<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-04 16:15:55
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-11 10:00:57
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
        $achievement2->setTitle(uniqid());
        $achievement2->setContent("Content");
        $achievement2->setPoints(10);

        $achievement3 = new Achievement();
        $achievement3->setTitle("Title");
        $achievement3->setContent("Content");

        $this->assertAdd($achievement1);
        $this->notAssertAdd($achievement2);
        $this->assertAdd($achievement3);
    }
}
