<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Achievement;

class AchievementController extends PController {

    public function allAction() {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return $this->jsonEntitiesResponse($entities);
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"salt": "salt"}})
     */
    public function getAction(Achievement $achievement) {
        return $this->jsonEntityResponse($achievement);
    }
}
