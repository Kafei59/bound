<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:18:36
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 15:28:22
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\Crew;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CrewManager extends PManager {

    public function add(Crew $crew) {
        $crew->slugifyTitle();

        if (!$this->alreadyExists($crew)) {
            if ($crew->getId() == NULL) {
                $this->pflush($crew);

                return $crew;
            } else {
                throw new HttpException(400, "Entity ID must be NULL.");
            }
        } else {
            throw new HttpException(409, "Entity already exists.");
        }
    }

    public function edit(Crew $crew) {
        $this->pflush($crew);

        return $crew;
    }

    public function delete(Crew $crew) {
        $this->rflush($crew);
    }

    public function alreadyExists(Crew $crew) {
        $entity = $this->manager->getRepository('BoundCoreBundle:Crew')->findOneBy(array('slug' => $crew->getSlug()));

        return $entity != NULL;
    }
};
