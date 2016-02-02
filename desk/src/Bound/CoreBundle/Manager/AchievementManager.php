<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:18:30
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-20 20:04:52
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Entity\User;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AchievementManager extends PManager {

    public function add(Achievement $achievement, User $user) {
        if ($user->isAdmin()) {
            $achievement->slugifyTitle();

            if (!$this->alreadyExists($achievement)) {
                if ($achievement->getId() == NULL) {
                    $this->pflush($achievement);
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

    public function edit(Achievement $achievement, Achievement $entity, User $user) {
        if ($user->isAdmin()) {
            $achievement->setTitle($entity->getTitle());
            $achievement->setContent($entity->getContent());
            $achievement->setPoints($entity->getPoints());

            $this->pflush($achievement);
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
