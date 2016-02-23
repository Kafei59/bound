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

use JMS\Serializer\SerializerBuilder;

class AchievementController extends AController {

    /**
     * Mapping [GET] /api/achievements
     */
    public function getAchievementsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return array('achievements' => $achievements);
    }

    /**
     * Mapping [GET] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function getAchievementAction(Achievement $achievement, Request $request) {
        $this->assertToken($request->get('token'));

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [POST] /api/achievements
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
     * Mapping [PUT] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
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
     * Mapping [DELETE] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function deleteAchievementAction(Achievement $achievement, Request $request) {
        $user = $this->assertToken($request->get('token'));
        $this->get('bound.achievement_manager')->delete($achievement, $user);

        return array();
    }
}
