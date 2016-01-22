<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 17:06:33
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-22 17:24:14
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Bound\ApiBundle\Controller\PController;
use Bound\CoreBundle\Entity\User;

use FOS\RestBundle\Controller\Annotations\Post;
use FOS\UserBundle\Util\TokenGenerator;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class SecurityController extends PController {

    /**
     * Mapping [POST] /api/login
     * @Post("/login")
     */
    public function loginAction(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');
         
        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByUsername($username);
        if (!$user) {
            $user = $um->findUserByEmail($username);
        }

        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        }

        if (!$this->checkUserPassword($user, $password)) {
            throw new HttpException(400, "Wrong credentials.");
        }
         
        $token = $this->get('bound.token_manager')->add($user);
        return array('token' => $token);
    }

    /**
     * Mapping [POST] /api/registration
     * @Post("/registration")
     */
    public function registrationAction(Request $request) {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($username and $email and $password) {
            $um = $this->get('bound.user_manager');
            if (!$um->usernameExists($username)) {
                if (!$um->emailExists($email)) {
                    $tg = new TokenGenerator();
                    $token = $tg->generateToken();
                    $fum = $this->container->get('fos_user.user_manager');
                    $url = $this->container->get('router')->generate('fos_user_registration_confirm', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                    $user = $fum->createUser();
                    $user->setUsername($username);
                    $user->setEmail($email);
                    $user->setPlainPassword($password);
                    $user->setConfirmationToken($token);

                    $fum->updateUser($user);

                    $this->sendConfirmationEmail($user, $url);
                    return array("Email sent to ".$user->getEmail().".");
                } else {
                    throw new HttpException(400, "Email already exists.");
                }
            } else {
                throw new HttpException(400, "Username already exists.");
            }
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }

    /**
     * Mapping [POST] /api/resetting
     * @Post("/resetting")
     */
    public function resettingAction(Request $request) {
        $email = $request->get('email');
        $fum = $this->get('fos_user.user_manager');
        $tg = new TokenGenerator();

        $um = $this->get('fos_user.user_manager');
        $user = $um->findUserByEmail($email);
        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        } else {
            if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
                throw new HttpException(400, "Password already requested.");
            } else {
                $token = $tg->generateToken();
                $user->setPlainPassword($token);
                $user->setPasswordRequestedAt(new \DateTime());

                $fum->updateUser($user);
                $this->sendResetEmail($user, $token);

                return array("Email sent to ".$user->getEmail().".");
            }
        }
    }

    private function checkUserPassword(User $user, $password) {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder) {
            return false;
        } else {
            return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        }
    }

    private function sendConfirmationEmail(User $user, $url) {
        $message = \Swift_Message::newInstance()
            ->setSubject("Prêt pour l'aventure ?")
            ->setFrom(array('hello@bound-app.com' => "Pierrick"))
            ->setTo($user->getEmail())
            ->setBody($this->renderView('registration.html.twig', array('user' => $user, 'url' => $url)), 'text/html')
        ;

        $this->get('mailer')->send($message);
    }

    private function sendResetEmail(User $user, $token) {
        $message = \Swift_Message::newInstance()
            ->setSubject("Alors, comme ça on a pas de mémoire ?")
            ->setFrom(array('hello@bound-app.com' => "Pierrick"))
            ->setTo($user->getEmail())
            ->setBody($this->renderView('resetting.html.twig', array('user' => $user, 'token' => $token)), 'text/html')
        ;

        $this->get('mailer')->send($message);        
    }
}
