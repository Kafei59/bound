<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations\View;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Crew;
use Bound\CoreBundle\Form\Type\CrewType;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class CrewController extends AController {

    /**
     * Mapping [GET] api.bound-app.com/crews?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste de toutes les crews",
     *  output="Bound\CoreBundle\Entity\Crew",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas"
     *  }
     * )
     */
    public function getCrewsAction(Request $request) {
        $this->assertToken($request->get('token'));
        $crews = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        return array('crews' => $crews);
    }

    /**
     * Mapping [GET] api.bound-app.com/crews/{crews}?token="token"
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne une crew",
     *  output="Bound\CoreBundle\Entity\Crew",
     *  requirements={
     *      {
     *          "name"="crew",
     *          "dataType"="string",
     *          "description"="Slug de la crew"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas",
     *     404="Retourner si la crew demandée n'existe pas"
     *  }
     * )
     */
    public function getCrewAction(Crew $crew, Request $request) {
        $this->assertToken($request->get('token'));

        return array('crew' => $crew);
    }

    /**
     * Mapping [POST] api.bound-app.com/crews?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Ajoute une nouvelle crew",
     *  input="Bound\CoreBundle\Form\Type\CrewType",
     *  output="Bound\CoreBundle\Entity\Crew",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     400="Retourner si un ID est précisé lors de la requête",
     *     403="Retourner si l'utilisateur n'existe pas",
     *     409="Retourner si la crew existe déjà"
     *  }
     * )
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
     * Mapping [PUT] api.bound-app.com/crews/{crew}?token="token"
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Modifie une crew",
     *  input="Bound\CoreBundle\Form\Type\CrewType",
     *  output="Bound\CoreBundle\Entity\Crew",
     *  requirements={
     *      {
     *          "name"="crew",
     *          "dataType"="string",
     *          "description"="Slug de la crew"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas",
     *     404="Retrouner si la crew n'existe pas"
     *  }
     * )
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
     * Mapping [DELETE] api.bound-app.com/crews/{crew}?token="token"
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Supprime une crew",
     *  output="array",
     *  requirements={
     *      {
     *          "name"="crew",
     *          "dataType"="string",
     *          "description"="Slug de la crew"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas",
     *     404="Retrouner si la crew n'existe pas"
     *  }
     * )
     */
    public function deleteCrewAction(Crew $crew, Request $request) {
        $this->assertToken($request->get('token'));
        $this->get('bound.crew_manager')->delete($crew);

        return array();
    }
}
