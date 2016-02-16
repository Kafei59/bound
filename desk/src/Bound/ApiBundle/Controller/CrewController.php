<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Crew;
use Bound\CoreBundle\Form\Type\CrewType;

class CrewController extends PController {

    /**
     * Mapping [GET] /api/crews
     */
    public function getCrewsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $crews = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        $this->get('bound.facebook_listener')->launch($user);

        return array('crews' => $crews, 'user' => $user);
    }

    /**
     * Mapping [GET] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function getCrewAction(Crew $crew, Request $request) {
        $this->assertToken($request->get('token'));

        return array('crew' => $crew);
    }

    /**
     * Mapping [POST] /api/crews
     */
    public function postCrewAction(Request $request) {
        $this->assertToken($request->get('token'));

        $crew = new Crew();
        $form = $this->createForm(new CrewType(), $crew, array('method' => "POST"));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('bound.crew_manager')->add($crew);

            return array('crew' => $crew);
        } else {
            return array('errors' => $form->getErrors());
        }
    }

    /**
     * Mapping [PUT] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function putCrewAction(Crew $crew, Request $request) {
        $this->assertToken($request->get('token'));

        $form = $this->createForm(new CrewType(), $crew, array('method' => "PUT"));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('bound.crew_manager')->edit($crew);

            return array('crew' => $crew);
        } else {
            return array('errors' => $form->getErrors());
        }
    }

    /**
     * Mapping [DELETE] /api/crews/{crew}
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     */
    public function deleteCrewAction(Crew $crew, Request $request) {
        $this->assertToken($request->get('token'));
        $this->get('bound.crew_manager')->delete($crew);

        return array();
    }
}
