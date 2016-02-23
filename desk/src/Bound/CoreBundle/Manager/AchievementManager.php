<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:18:30
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 11:09:50
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\AManager;
use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AchievementManager extends AManager {

    public function add(Achievement $achievement, User $user) {
        if ($user->isAdmin()) {
            $achievement->slugifyTitle();

            if (!$this->alreadyExists($achievement)) {
                if ($achievement->getId() == NULL) {
                    $this->pflush($achievement);

                    return $achievement;
                } else {
                    throw new HttpException(400, "Entity ID must be NULL.");
                }
            } else {
                throw new HttpException(409, "Entity already exists.");
            }
        } else {
            throw new HttpException(403, "Access Denied.");
        }
    }

    public function edit(Achievement $achievement, User $user) {
        if ($user->isAdmin()) {
            $this->pflush($achievement);

            return $achievement;
        } else {
            throw new HttpException(403, "Access Denied.");
        }
    }

    public function delete(Achievement $achievement, User $user) {
        if ($user->isAdmin()) {
            $this->rflush($achievement);
        } else {
            throw new HttpException(403, "Access Denied.");
        }
    }

    public function alreadyExists(Achievement $achievement) {
        $entity = $this->manager->getRepository('BoundCoreBundle:Achievement')->findOneBy(array('slug' => $achievement->getSlug()));

        return $entity != NULL;
    }
};
