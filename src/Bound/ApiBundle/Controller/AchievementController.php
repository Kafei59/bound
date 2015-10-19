<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\CoreBundle\Entity\Achievement;

class AchievementController extends Controller {

    public function allAction(Request $request) {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        $achievements = array();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $achievements[$entity->getId()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($achievements, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"salt": "salt"}})
     */
    public function getAction(Achievement $achievement, Request $request) {
        $response = new JsonResponse($achievement->toArray(), 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }
}
