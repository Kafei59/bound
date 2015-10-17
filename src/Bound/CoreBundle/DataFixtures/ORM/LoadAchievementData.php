<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-10-17 18:28:49
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Bound\CoreBundle\Entity\Achievement;

class LoadAchievementData implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $achievement1 = new Achievement();
        $achievement2 = new Achievement();

        $achievement1->setTitle("Cheerleader");
        $achievement1->setContent("Avoir 10 amis");
        $achievement1->setPoints(10);

        $achievement2->setTitle("Globetrotter");
        $achievement2->setContent("Visiter 3 pays différents");
        $achievement2->setPoints(20);

        $manager->persist($achievement1);
        $manager->persist($achievement2);
        $manager->flush();
    }
};
