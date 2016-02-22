<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-22 19:54:38
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
        $achievement3 = new Achievement();
        $achievement4 = new Achievement();
        $achievement5 = new Achievement();

        $achievement1->setTitle("Inconnu");
        $achievement1->setContent("Avoir au moins 50 amis sur Facebook");
        $achievement1->setPoints(10);
        $achievement1->setType("test");
        $achievement1->setFunctionId("test");

        $achievement2->setTitle("Fréquenté");
        $achievement2->setContent("Avoir au moins 300 amis sur Facebook");
        $achievement2->setPoints(25);
        $achievement2->setType("test");
        $achievement2->setFunctionId("test");

        $achievement3->setTitle("Cheerleader");
        $achievement3->setContent("Avoir au moins 1000 amis sur Facebook");
        $achievement3->setPoints(50);
        $achievement3->setType("test");
        $achievement3->setFunctionId("test");

        $achievement4->setTitle("Star");
        $achievement4->setContent("Avoir au moins 2500 amis sur Facebook");
        $achievement4->setPoints(100);
        $achievement4->setType("test");
        $achievement4->setFunctionId("test");

        $achievement5->setTitle("Globetrotter");
        $achievement5->setContent("Visiter 3 pays différents");
        $achievement5->setPoints(20);
        $achievement5->setType("test");
        $achievement5->setFunctionId("test");

        $user = new User();
        $user->setRoles(array('ROLE_ADMIN'));

        $this->container->get('bound.achievement_manager')->add($achievement1, $user);
        $this->container->get('bound.achievement_manager')->add($achievement2, $user);
        $this->container->get('bound.achievement_manager')->add($achievement3, $user);
        $this->container->get('bound.achievement_manager')->add($achievement4, $user);
        $this->container->get('bound.achievement_manager')->add($achievement5, $user);
    }
};
