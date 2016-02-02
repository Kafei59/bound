<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-02 12:02:48
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;
use Bound\CoreBundle\Entity\Crew;

class LoadUserData extends ContainerAware implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $fum = $this->container->get('fos_user.user_manager');

        $player = new Player();
        $client = new Client();
        $user = $fum->createUser();
        $user->setUsername("Madvenger");
        $user->setEmail("toto@mail.com");
        $user->setPlainPassword("toto");
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));
        $user->setPlayer($player);
        $user->setClient($client);

        $manager->persist($player);
        $manager->persist($client);
        $fum->updateUser($user);

        $player = new Player();
        $client = new Client();
        $user = $fum->createUser();
        $user->setUsername("Kafei");
        $user->setEmail("email@mail.com");
        $user->setPlainPassword("toto");
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));
        $user->setPlayer($player);
        $user->setClient($client);

        $crew = new Crew();
        $crew->setTitle("My special crew, bae");
        $crew->setMembers(array($user->getUsername()));

        $manager->persist($crew);
        $manager->flush();

        $player->setFriends(array("Madvenger"));
        $player->setCrew($crew);

        $manager->persist($player);
        $manager->persist($client);
        $fum->updateUser($user);
    }
};
