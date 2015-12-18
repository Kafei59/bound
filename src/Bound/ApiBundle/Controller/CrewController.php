<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Crew;

class CrewController extends PController {

    /**
     * Mapping [GET] /api/crews
     */
    public function getCrewsAction() {
        $crews = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        return array('crew' => $crews);
    }

    /**
     * Mapping [GET] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function getCrewAction(Crew $crew) {
        return array('crew' => $crew);
    }

    /**
     * Mapping [POST] /api/crews
     */
    public function postCrewAction(Request $request) {
        $crew = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Crew');
        $this->get('bound.crew_manager')->add($crew);

        return array('crew' => $crew);
    }

    /**
     * Mapping [PUT] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function putCrewAction(Crew $crew, Request $request) {
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Crew');
        $this->get('bound.crew_manager')->modify($crew, $entity);

        return array('crew' => $crew);
    }

    /**
     * Mapping [DELETE] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function deleteCrewAction(Crew $crew) {
        $this->get('bound.crew_manager')->delete($crew);

        return array();
    }
}
