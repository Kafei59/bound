<?php

namespace Bound\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('BoundCoreBundle::layout.html.twig');
    }
}
