<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Crew;

class CrewController extends PController {

    public function allAction(Request $request) {
        $this->assertRequestMethod($request, 'GET');
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        return $this->jsonEntitiesResponse($entities);
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"slug": "slug"}})
     */
    public function getAction(Crew $crew, Request $request) {
        $this->assertRequestMethod($request, 'GET');

        return $this->jsonEntityResponse($crew);
    }

    public function postAction(Request $request) {
        $this->assertRequestMethod($request, 'POST');
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Crew');

        $this->get('bound.crew_manager')->add($entity);

        return new Response($entity->getTitle(), 200);
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"slug": "slug"}})
     */
    public function putAction(Crew $crew, Request $request) {
        $this->assertRequestMethod($request, 'PUT');
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Crew');

        $this->get('bound.crew_manager')->modify($crew, $entity);

        return new Response(NULL, 200);
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"slug": "slug"}})
     */
    public function deleteAction(Crew $crew, Request $request) {
        $this->assertRequestMethod($request, 'DELETE');

        $this->get('bound.crew_manager')->delete($crew);

        return new Response(NULL, 200);
    }
}
