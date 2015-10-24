<?php

namespace Bound\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller {

    public function indexAction() {
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') or $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('BoundFrontBundle::layout.html.twig');
        } else {
            return new JsonResponse(array());
        }
    }
}
