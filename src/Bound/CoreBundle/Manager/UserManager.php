<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-15 16:31:53
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-20 20:05:55
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;

class UserManager extends PManager {

    public function modify() {
        
    }

    public function usernameExists($username) {
        $entity = $this->manager->getRepository('BoundCoreBundle:User')->findOneBy(array('username' => $username));

        return $entity != NULL;
    }

    public function emailExists($email) {
        $entity = $this->manager->getRepository('BoundCoreBundle:User')->findOneBy(array('email' => $email));

        return $entity != NULL;
    }
};
