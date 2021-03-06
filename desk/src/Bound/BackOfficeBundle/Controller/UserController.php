<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-06 16:16:49
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-22 14:41:06
 */

namespace Bound\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Manager\UserManager;

class UserController extends Controller {

    public function listAction() {
        $users = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

        return $this->render('BoundBackOfficeBundle:User:list.html.twig', array('users' => $users));
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user": "slug"}})
    */
    public function detailAction(User $user) {
        return $this->render('BoundBackOfficeBundle:User:detail.html.twig', array('user' => $user));
    }

    public function createAction() {
        return $this->render('BoundBackOfficeBundle:User:form.html.twig', array('form' => array()));
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user": "slug"}})
    */
    public function editAction(User $user) {
        $user = $user;

        return $this->render('BoundBackOfficeBundle:User:form.html.twig', array('form' => array()));
    }

    /**
     * @ParamConverter("user", options={"mapping": {"user": "slug"}})
    */
    public function deleteAction(User $user) {
        $user = $user;

        return $this->redirect($this->generateUrl('bound_backoffice_user_list'));        
    }
}
