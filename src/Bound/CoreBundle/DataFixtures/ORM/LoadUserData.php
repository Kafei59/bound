<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-17 18:22:12
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-10-19 12:03:08
 */

namespace Bound\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAware;

use Bound\UserBundle\Entity\User;

class LoadUserData extends ContainerAware implements FixtureInterface {

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {
        $uManager = $this->container->get('fos_user.user_manager');

        $user = $uManager->createUser();
        $user->setUsername("Kafei");
        $user->setEmail("email@mail.com");
        $user->setPlainPassword("toto");
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_SUPER_ADMIN'));

        $uManager->updateUser($user);
    }
};
