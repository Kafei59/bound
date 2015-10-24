<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-10-24 18:57:48
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\UserBundle\Entity\User;
use Bound\CoreBundle\Entity\Crew;

class LoadUserData extends ContainerAware implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $uManager = $this->container->get('fos_user.user_manager');

        $user = $uManager->createUser();
        $user->setUsername("Madvenger");
        $user->setEmail("toto@mail.com");
        $user->setPlainPassword("toto");
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        $uManager->updateUser($user);

        $user = $uManager->createUser();
        $user->setUsername("Kafei");
        $user->setEmail("email@mail.com");
        $user->setPlainPassword("toto");
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        $crew = new Crew();
        $crew->setTitle("My special crew, bae");
        $crew->setMembers(array($user->getUsername()));

        $manager->persist($crew);
        $manager->flush();

        $user->setFriends(array("Madvenger"));
        $user->setCrew($crew);

        $uManager->updateUser($user);
    }
};
