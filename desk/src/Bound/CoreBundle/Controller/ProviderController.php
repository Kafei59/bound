<?php
/**
 * @Author: root
 * @Date:   2016-02-17 11:39:22
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-26 00:50:41
 */

namespace Bound\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProviderController extends Controller {

    public function redirectToServiceAction(Request $request, $service) {
        $authorizationUrl = $this->container->get('hwi_oauth.security.oauth_utils')->getAuthorizationUrl($request, $service);

        if ($request->hasSession()) {
            $session = $request->getSession();
            $session->start();

            if ($request->get('token')) {
                $session->getFlashBag()->add('token', $request->get('token'));
            }

            $session->getFlashBag()->add('action', $request->get('action'));
            foreach ($this->container->getParameter('hwi_oauth.firewall_names') as $providerKey) {
                $sessionKey = '_security.'.$providerKey.'.target_path';

                $param = $this->container->getParameter('hwi_oauth.target_path_parameter');
                if (!empty($param) && $targetUrl = $request->get($param)) {
                    $session->set($sessionKey, $targetUrl);
                }

                if ($this->container->getParameter('hwi_oauth.use_referer') && !$session->has($sessionKey) && ($targetUrl = $request->headers->get('Referer')) && $targetUrl !== $authorizationUrl) {
                    $session->set($sessionKey, $targetUrl);
                }
            }
        }

        return $this->redirect($authorizationUrl);
    }

    public function backFromServiceAction(Request $request) {
        $error = $request->getSession()->getFlashBag()->get('error');
        $action = $request->getSession()->getFlashBag()->get('action')[0];

        if (array_key_exists(0, $error)) {
            $error = $error[0];

            $uri = "/#/?";
            switch ($action) {
                case 'login':
                    $uri = "/#login/?error=";
                    break;
                case 'register':
                    $uri = "/#register/?error=";
                    break;
                case 'associate':
                    $uri = "/#dashboard/?error=";
                    break;
            }

            return $this->redirect($this->container->getParameter('redirect_uri').$uri.$error);
        } else {
            $uri = "/#/?";
            switch ($action) {
                case 'login':
                    $token = $request->getSession()->getFlashBag()->get('token')[0];
                    $uri = "/#login/?token=";
                    $value = $token;
                    break;
                case 'register':
                    $uri = "/#login/?redirect=";
                    $value = "Check out your mails and log in.";
                    break;
                case 'associate':
                    $uri = "/#dashboard/?redirect=";
                    $value = "Account associate.";
                    break;
            }

            return $this->redirect($this->container->getParameter('redirect_uri').$uri.$value);
        }
    }
}
