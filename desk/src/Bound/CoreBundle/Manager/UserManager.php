<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-15 16:31:53
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-14 18:44:26
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\PManager;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Util\TokenGenerator;

class UserManager extends PManager {

    public function add($username, $email, $password) {
        $fum = $this->container->get('fos_user.user_manager');
        if (!$fum->findUserByUsername($username)) {
            if (!$fum->findUserByEmail($email)) {
                $tg = new TokenGenerator();
                $token = $tg->generateToken();

                $fum = $this->container->get('fos_user.user_manager');
                $url = $this->container->get('router')->generate('fos_user_registration_confirm', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                $player = new Player();
                $this->persist($player);

                $client = new Client();
                $this->persist($client);

                $user = $fum->createUser();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPlainPassword($password);
                $user->setConfirmationToken($token);
                $user->setPlayer($player);
                $user->setClient($client);

                $fum->updateUser($user);

                if ($this->container->get('kernel')->getEnvironment() != "test") {
                    $this->sendConfirmationEmail($user, $url);
                }

                return $user;
            } else {
                throw new HttpException(400, "Email already exists.");
            }
        } else {
            throw new HttpException(400, "Username already exists.");
        }
    }

    public function changePassword($email) {
        $fum = $this->container->get('fos_user.user_manager');
        $user = $fum->findUserByEmail($email);

        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        } else {
            if ($user->isPasswordRequestNonExpired($this->container->getParameter('fos_user.resetting.token_ttl'))) {
                throw new HttpException(400, "Password already requested.");
            } else {
                $tg = new TokenGenerator();
                $token = $tg->generateToken();

                $user->setPlainPassword($token);
                $user->setPasswordRequestedAt(new \DateTime());
                $fum->updateUser($user);

                if ($this->container->get('kernel')->getEnvironment() != "test") {
                    $this->sendResetEmail($user, $token);
                }

                return $user;
            }
        }
    }

    private function sendConfirmationEmail(User $user, $url) {
        $message = \Swift_Message::newInstance()
            ->setSubject("Prêt pour l'aventure ?")
            ->setFrom(array('hello@bound-app.com' => "Pierrick"))
            ->setTo($user->getEmail())
            ->setBody($this->container->get('templating')->render('registration.html.twig', array('user' => $user, 'url' => $url)), 'text/html')
        ;

        $this->container->get('mailer')->send($message);
    }

    private function sendResetEmail(User $user, $token) {
        $message = \Swift_Message::newInstance()
            ->setSubject("Alors, comme ça on a pas de mémoire ?")
            ->setFrom(array('hello@bound-app.com' => "Pierrick"))
            ->setTo($user->getEmail())
            ->setBody($this->container->get('templating')->render('resetting.html.twig', array('user' => $user, 'token' => $token)), 'text/html')
        ;

        $this->container->get('mailer')->send($message);
    }
};
