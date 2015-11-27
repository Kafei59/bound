<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Crew;

class CrewController extends PController {

    public function allAction() {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        return $this->jsonEntitiesResponse($entities);
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"salt": "salt"}})
     */
    public function getAction(Crew $crew) {
        return $this->jsonEntityResponse($crew);
    }
}
