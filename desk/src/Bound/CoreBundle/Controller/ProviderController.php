<?php
/**
 * @Author: root
 * @Date:   2016-02-17 11:39:22
 * @Last Modified by:   root
 * @Last Modified time: 2016-02-17 11:40:39
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

        // Check for a return path and store it before redirect
        if ($request->hasSession()) {
            // initialize the session for preventing SessionUnavailableException
            $session = $request->getSession();
            $session->start();

            $session->set('token', $request->get('token'));
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
}
