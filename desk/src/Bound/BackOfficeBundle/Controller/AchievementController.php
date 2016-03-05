<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-05 21:10:59
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-05 21:12:02
 */

namespace Bound\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Bound\CoreBundle\Entity\Achievement;

class AchievementController extends Controller {

    public function listAction() {
        $achievements = $this->getDoctrine()->getRepository('BoundCoreBundle:Achievement')->findAll();

        return $this->render('BoundBackOfficeBundle:Achievement:list.html.twig', array('achievements' => $achievements));
    }
}
