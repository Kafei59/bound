<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 15:27:02
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Entity\User;

class LoadAchievementData extends ContainerAware implements FixtureInterface {

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

        $user = new User();
        $user->setRoles(array('ROLE_ADMIN'));

        $this->container->get('bound.achievement_manager')->add($achievement1, $user);
        $this->container->get('bound.achievement_manager')->add($achievement2, $user);
    }
};
