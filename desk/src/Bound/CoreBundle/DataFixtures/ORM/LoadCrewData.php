<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 15:29:54
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\CoreBundle\Entity\Crew;
use Bound\CoreBundle\Entity\User;

class LoadCrewData extends ContainerAware implements FixtureInterface {

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

        $user = new User();
        $user->setRoles(array('ROLE_ADMIN'));

        $this->container->get('bound.crew_manager')->add($crew1, $user);
        $this->container->get('bound.crew_manager')->add($crew2, $user);
    }
};
