<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-05 21:10:59
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-22 14:37:33
 */

namespace Bound\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\CoreBundle\Entity\Achievement;
use Bound\CoreBundle\Manager\AchievementManager;
use Bound\CoreBundle\Form\Type\AchievementType;

class AchievementController extends Controller {

    public function listAction() {
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return $this->render('BoundBackOfficeBundle:Achievement:list.html.twig', array('achievements' => $achievements));
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
    */
    public function detailAction(Achievement $achievement) {
        return $this->render('BoundBackOfficeBundle:Achievement:detail.html.twig', array('achievement' => $achievement));
    }

    public function createAction() {
        $achievement = new Achievement();
        $form = $this->createForm(new AchievementType(), $achievement);

        return $this->render('BoundBackOfficeBundle:Achievement:form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
    */
    public function editAction(Achievement $achievement) {
        $form = $this->createForm(new AchievementType(), $achievement);

        return $this->render('BoundBackOfficeBundle:Achievement:form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @ParamConverter("achievement", options={"mapping": {"achievement": "slug"}})
    */
    public function deleteAction(Achievement $achievement) {
        $user = $this->getUser();
        $this->get('bound.achievement_manager')->delete($achievement, $user);

        return $this->redirect($this->generateUrl('bound_backoffice_achievement_list'));        
    }
}
