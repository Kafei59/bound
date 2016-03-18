<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Form\Type\AchievementType;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Get;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class AchievementController extends AController {

    /**
     * Mapping [GET] api.bound-app.com/achievements?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste de tous les haut-faits",
     *  output="Bound\CoreBundle\Entity\Achievement",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin"
     *  }
     * )
     */
    public function getAchievementsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return array('achievements' => $achievements);
    }

    /**
     * Mapping [GET] api.bound-app.com/achievements/type/{type}?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @Get("/achievements/type/{type}")
     * @ApiDoc(
     *  description="Retourne la liste de tous les haut-faits du type en question",
     *  output="Bound\CoreBundle\Entity\Achievement",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin"
     *  }
     * )
     */
    public function getAchievementsByTypeAction($type, Request $request) {
        $this->assertToken($request->get('token'));
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findByType($type);

        return array('achievements' => $achievements);
    }

    /**
     * Mapping [GET] api.bound-app.com/achievements/{achievement}?token="token"
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne un haut-fait",
     *  output="Bound\CoreBundle\Entity\Achievement",
     *  requirements={
     *      {
     *          "name"="achievement",
     *          "dataType"="string",
     *          "description"="Slug du haut-fait"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin",
     *     404="Retourner si le haut-fait demandé n'existe pas"
     *  }
     * )
     */
    public function getAchievementAction(Achievement $achievement, Request $request) {
        $this->assertToken($request->get('token'));

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [POST] api.bound-app.com/achievements?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Ajoute un nouvel haut-fait",
     *  input="Bound\CoreBundle\Form\Type\AchievementType",
     *  output="Bound\CoreBundle\Entity\Achievement",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     400="Retourner si un ID est précisé lors de la requête",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin",
     *     409="Retourner si le haut-fait existe déjà"
     *  }
     * )
     */
    public function postAchievementAction(Request $request) {
        $user = $this->assertToken($request->get('token'));

        $achievement = new Achievement();
        $form = $this->createForm(new AchievementType(), $achievement, array('method' => "POST"));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('bound.achievement_manager')->add($achievement, $user);

            return array('achievement' => $achievement);
        } else {
            return array('errors' => $form->getErrors());
        }
    }

    /**
     * Mapping [PUT] api.bound-app.com/achievements/{achievement}?token="token"
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Modifie un haut-fait",
     *  input="Bound\CoreBundle\Form\Type\AchievementType",
     *  output="Bound\CoreBundle\Entity\Achievement",
     *  requirements={
     *      {
     *          "name"="achievement",
     *          "dataType"="string",
     *          "description"="Slug du haut-fait"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin",
     *     404="Retrouner si le haut-fait n'existe pas"
     *  }
     * )
     */
    public function putAchievementAction(Achievement $achievement, Request $request) {
        $user = $this->assertToken($request->get('token'));

        $form = $this->createForm(new AchievementType(), $achievement, array('method' => "PUT"));
        $form->handleRequest($request);
        if ($form->isValid()) {
            $this->get('bound.achievement_manager')->edit($achievement, $user);

            return array('achievement' => $achievement);
        } else {
            return array('errors' => $form->getErrors());
        }
    }

    /**
     * Mapping [DELETE] api.bound-app.com/achievements/{achievement}?token="token"
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Supprime un haut-fait",
     *  output="array",
     *  requirements={
     *      {
     *          "name"="achievement",
     *          "dataType"="string",
     *          "description"="Slug du haut-fait"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin",
     *     404="Retrouner si le haut-fait n'existe pas"
     *  }
     * )
     */
    public function deleteAchievementAction(Achievement $achievement, Request $request) {
        $user = $this->assertToken($request->get('token'));
        $this->get('bound.achievement_manager')->delete($achievement, $user);

        return array();
    }

    /**
     * Mapping [GET] api.bound-app.com/achievements/load?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Charge les checks de haut-faits",
     *  output="array",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin"
     *  }
     * )
     */
    public function loadAchievementsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $this->get('bound.achievement_listener')->loadAll($user);

        return array();
    }
}
