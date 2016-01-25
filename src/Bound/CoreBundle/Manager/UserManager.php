<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-15 16:31:53
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-01-25 12:29:43
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Manager\PManager;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Util\TokenGenerator;

class UserManager extends PManager {

    public function add($username, $email, $password) {
        $tg = new TokenGenerator();
        $token = $tg->generateToken();

        $fum = $this->container->get('fos_user.user_manager');
        $url = $this->container->get('router')->generate('fos_user_registration_confirm', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

        $player = new Player();
        $this->persist($player);

        $user = $fum->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setConfirmationToken($token);
        $user->setPlayer($player);

        $fum->updateUser($user);

        $this->sendConfirmationEmail($user, $url);
    }

    public function changePassword(User $user) {
        $tg = new TokenGenerator();
        $token = $tg->generateToken();
        $fum = $this->container->get('fos_user.user_manager');

        $user->setPlainPassword($token);
        $user->setPasswordRequestedAt(new \DateTime());
        $fum->updateUser($user);

        $this->sendResetEmail($user, $token);
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
