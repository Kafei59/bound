<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Achievement;

use JMS\Serializer\SerializerBuilder;

class AchievementController extends PController {

    public function allAction(Request $request) {
        $this->assertRequestMethod($request, 'GET');
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return $this->jsonEntitiesResponse($entities);
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"slug": "slug"}})
     */
    public function getAction(Achievement $achievement, Request $request) {
        $this->assertRequestMethod($request, 'GET');

        return $this->jsonEntityResponse($achievement);
    }

    public function postAction(Request $request) {
        $this->assertRequestMethod($request, 'POST');
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');

        $this->get('bound.achievement_manager')->add($entity);

        return new Response($entity->getTitle(), 200);
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"slug": "slug"}})
     */
    public function putAction(Achievement $achievement, Request $request) {
        $this->assertRequestMethod($request, 'PUT');
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');

        // Find a better solution
        $achievement->setTitle($entity->getTitle());
        $achievement->setContent($entity->getContent());
        $achievement->setPoints($entity->getPoints());

        $this->get('bound.achievement_manager')->modify($achievement);

        return new Response($entity->getTitle(), 200);
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"slug": "slug"}})
     */
    public function deleteAction(Achievement $achievement, Request $request) {
        $this->assertRequestMethod($request, 'DELETE');

        $this->get('bound.achievement_manager')->delete($achievement);

        return new Response("toto", 200);
    }
}
