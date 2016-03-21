<?php
/**
 * @Author: gicque_p
 * @Date:   2015-10-15 16:31:53
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-03-21 14:55:57
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\AManager;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use FOS\UserBundle\Util\TokenGenerator;

class UserManager extends AManager {

    public function add($username, $email, $password, $enabled = false) {
        $fum = $this->container->get('fos_user.user_manager');
        if (!$fum->findUserByUsername($username)) {
            if (!$fum->findUserByEmail($email)) {
                $tg = new TokenGenerator();
                $token = $tg->generateToken();

                $fum = $this->container->get('fos_user.user_manager');
                $url = $this->container->get('router')->generate('fos_user_registration_confirm', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

                $user = $fum->createUser();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPlainPassword($password);
                $user->setConfirmationToken($token);
                $user->setEnabled($enabled);

                $player = new Player();
                $player->setPlayername($user->getUsername());
                $this->persist($player);

                $client = new Client();
                $this->persist($client);

                $user->setPlayer($player);
                $user->setClient($client);
                $fum->updateUser($user);

                $this->container->get('bound.notification_manager')->add($player, "Inscription", "Bienvenue, amuses-toi bien sur Bound", "bound");
                if ($this->container->get('kernel')->getEnvironment() != "test" and !$user->isEnabled()) {
                    $subject = "Prêt pour l'aventure ?";
                    $from = array('hello@bound-app.com' => "Pierrick");
                    $to = $user->getEmail();
                    $body = $this->container->get('templating')->render('registration.html.twig', array('user' => $user, 'url' => $url));

                    $this->container->get('bound.email_listener')->send($subject, $from, $to, $body);
                }

                return $user;
            } else {
                throw new HttpException(409, "Email already exists.");
            }
        } else {
            throw new HttpException(409, "Username already exists.");
        }
    }

    public function delete(User $user) {
        $this->rflush($user);
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
                    $subject = "Alors, comme ça on a pas de mémoire ?";
                    $from = array('hello@bound-app.com' => "Pierrick");
                    $to = $user->getEmail();
                    $body = $this->container->get('templating')->render('resetting.html.twig', array('user' => $user, 'token' => $token));

                    $this->container->get('bound.email_listener')->send($subject, $from, $to, $body);
                }

                return $user;
            }
        }
    }
};
