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

    /**
     * Mapping [GET] /api/achievements
     */
    public function getAchievementsAction() {
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return array('achievements' => $achievements);
    }

    /**
     * Mapping [GET] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function getAchievementAction(Achievement $achievement) {
        return array('achievement' => $achievement);
    }

    /**
     * Mapping [POST] /api/achievements
     */
    public function postAchievementAction(Request $request) {
        $achievement = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');
        $this->get('bound.achievement_manager')->add($achievement, $request->get('token'));

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [PUT] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function putAchievementAction(Achievement $achievement, Request $request) {
        $entity = $this->createEntityFromContent($request->getContent(), 'Bound\CoreBundle\Entity\Achievement');
        $this->get('bound.achievement_manager')->modify($achievement, $entity);

        return array('achievement' => $achievement);
    }

    /**
     * Mapping [DELETE] /api/achievements/{achievement}
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
     */
    public function deleteAchievementAction(Achievement $achievement) {
        $this->get('bound.achievement_manager')->delete($achievement);

        return array();
    }
}
