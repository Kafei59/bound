<?php

namespace Bound\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Security\Core\Security;

class DefaultController extends Controller {

    public function indexAction(Request $request) {
        $securityContext = $this->container->get('security.context');

        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY') or $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('BoundFrontBundle::layout.html.twig');
        } else {
            $form = $this->container->get('fos_user.registration.form');
            $data = $this->loginController($request);

            return $this->render('BoundFrontBundle::visitor.html.twig', array(
                'form' => $form->createView(),
                'csrf_token' => $data['csrf_token'],
                'last_username' => $data['last_username']
            ));
        }
    }

    protected function loginController(Request $request) {
        $session = $request->getSession();
        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }

        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null;
        }

        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);
        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            $csrfToken = $this->has('form.csrf_provider') ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate') : null;
        }

        return array('csrf_token' => $csrfToken, 'last_username' => $lastUsername);
    }
}
