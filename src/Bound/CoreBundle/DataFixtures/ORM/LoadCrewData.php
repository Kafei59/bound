<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-10-19 11:44:01
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Bound\CoreBundle\Entity\Crew;

class LoadCrewData implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $crew1 = new Crew();
        $crew2 = new Crew();

        $crew1->setTitle("The Clou");
        $crew1->setMembers(array("Kafei", "Madvenger"));

        $crew2->setTitle("Against All Authority");
        $crew2->setMembers(array("Noob1", "Noob2"));

        $manager->persist($crew1);
        $manager->persist($crew2);
        $manager->flush();
    }
};
