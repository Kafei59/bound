<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\Achievement;

use JMS\Serializer\SerializerBuilder;

class AchievementController extends PController {

    /**
     * Mapping [GET] /api/achievements
     */
    public function getAchievementsAction() {
        $this->assertToken($request->get('token'));
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
        $achievement = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');
        $this->get('bound.achievement_manager')->add($achievement, $user);

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [PUT] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function putAchievementAction(Achievement $achievement, Request $request) {
        $this->assertToken($request->get('token'));
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');
        $this->get('bound.achievement_manager')->edit($achievement, $entity, $user);

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [DELETE] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function deleteAchievementAction(Achievement $achievement) {
        $this->assertToken($request->get('token'));
        $this->get('bound.achievement_manager')->delete($achievement, $user);

        return array();
    }
}
