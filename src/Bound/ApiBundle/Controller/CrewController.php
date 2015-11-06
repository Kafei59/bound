<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\CoreBundle\Entity\Crew;

class CrewController extends Controller {

    public function allAction() {
        $entities = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        $crews = array();
        if (!empty($entities)) {
            foreach ($entities as $entity) {
                $crews[$entity->getId()] = $entity->toArray();
            }

            $status = 200;
        } else {
            $status = 500;
        }

        $response = new JsonResponse($crews, $status);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"salt": "salt"}})
     */
    public function getAction(Crew $crew) {
        $response = new JsonResponse($crew->toArray(), 200);
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;
    }
}
