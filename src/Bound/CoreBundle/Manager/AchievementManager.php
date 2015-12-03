<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:18:30
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-03 12:34:13
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Achievement;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AchievementManager extends PManager {

    public function add(Achievement $achievement) {
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
    }

    public function modify(Achievement $achievement) {
        $achievement->slugifyTitle();
        $this->pflush($achievement);
    }

    public function delete(Achievement $achievement) {
        $this->rflush($achievement);
    }

    public function alreadyExists(Achievement $achievement) {
        $entity = $this->manager->getRepository('BoundCoreBundle:Achievement')->findOneBy(array('slug' => $achievement->getSlug()));

        return $entity != NULL;
    }
};
