<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 17:13:39
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;
use Bound\CoreBundle\Entity\Crew;
use Bound\CoreBundle\Entity\Achievement;

class LoadUserData extends ContainerAware implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $admin = $this->container->get('bound.user_manager')->add("Kafei", "email@mail.com", "toto");
        $admin->setRoles(array('ROLE_ADMIN'));
        $admin->setEnabled(true);
        $manager->persist($admin);
        $manager->flush();

        $notAdmin = $this->container->get('bound.user_manager')->add("Madvenger", "toto@mail.com", "toto");

        $player = $admin->getPlayer();
        $player2 = $notAdmin->getPlayer();

        $player->addFriend($player2);

        $manager->persist($player);
        $manager->flush();
    }
};
