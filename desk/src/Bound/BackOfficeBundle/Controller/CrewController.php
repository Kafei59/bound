<?php
/**
 * @Author: Kafei59
 * @Date:   2016-03-06 16:16:44
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-06 17:49:27
 */

namespace Bound\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\CoreBundle\Entity\Crew;
use Bound\CoreBundle\Manager\CrewManager;
use Bound\CoreBundle\Form\Type\CrewType;

class CrewController extends Controller {

    public function listAction() {
        $crews = $this->getDoctrine()->getRepository('BoundCoreBundle:Crew')->findAll();

        return $this->render('BoundBackOfficeBundle:Crew:list.html.twig', array('crews' => $crews));
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
    */
    public function detailAction(Crew $crew) {
        return $this->render('BoundBackOfficeBundle:Crew:detail.html.twig', array('crew' => $crew));
    }

    public function createAction() {
        $crew = new Crew();
        $form = $this->createForm(new CrewType(), $crew);

        return $this->render('BoundBackOfficeBundle:Crew:form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
    */
    public function editAction(Crew $crew) {
        $form = $this->createForm(new CrewType(), $crew);

        return $this->render('BoundBackOfficeBundle:Crew:form.html.twig', array('form' => $form->createView()));
    }

    /**
     * @ParamConverter("crew", options={"mapping": {"crew": "slug"}})
    */
    public function deleteAction(Crew $crew) {
        return $this->redirect($this->generateUrl('bound_backoffice_crew_list'));        
    }
}
