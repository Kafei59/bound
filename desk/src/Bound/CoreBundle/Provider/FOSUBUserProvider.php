<?php

namespace Bound\CoreBundle\Provider;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Client;
use Bound\CoreBundle\Entity\Token;

class FOSUBUserProvider extends BaseClass {

    private $container;
    private $manager;
    private $session;

    public function __construct(Container $container, EntityManager $manager, UserManager $userManager, $options) {
        parent::__construct($userManager, $options);

        $this->container = $container;
        $this->manager = $manager;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $this->session = $this->container->get('request')->getSession();

        $action = $this->session->getFlashBag()->get('action');
        $this->session->getFlashBag()->set('action', $action);

        if ($response->getEmail()) {        
            switch ($action[0]) {
                case 'login':
                    $this->login($response);
                    break;
                case 'register':
                    $this->register($response);
                    break;
                case 'associate':
                    $this->associate($response);
                    break;
            }
        } else {
            $this->session->getFlashBag()->add('error', "You must provider user_email information");
        }
    }

    private function login(UserResponseInterface $response) {
        $password = $response->getUsername();
        $email = $response->getEmail();
        $service = $response->getResourceOwner()->getName();

        $user = $this->container->get('doctrine')->getRepository('BoundCoreBundle:User')->findOneByEmail($email);
        if ($user instanceof User) {
            $client = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Client')->findOneBy(array($service.'_id' => $password));
            if ($client instanceof Client) {
                if ($user->getClient() and $user->getClient()->getId() == $client->getId()) {
                    if ($user->isEnabled()) {                    
                        $token = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Token')->findOneByUser($user);
                        if (!$token) {
                            $token = $this->container->get('bound.token_manager')->add($user);
                        }
                        $this->session->getFlashBag()->add('token', $token->getData());

                        return $user;
                    } else {
                        $this->session->getFlashBag()->add('error', "Check out your mails to enable your account.");
                    }
                } else {
                    $this->session->getFlashBag()->add('error', "Client and user are not bound.");
                }
            } else {
                $this->session->getFlashBag()->add('error', "Client not found.");
            }
        } else {
            $this->session->getFlashBag()->add('error', "User not found.");
        }
    }

    private function register(UserResponseInterface $response) {
        $username = $response->getRealName();
        $email = $response->getEmail();
        $password = $response->getUsername();

        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        $client = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Client')->findOneBy(array($service.'_id' => $password));
        if ($client instanceof Client) {
            $this->session->getFlashBag()->add('error', "Client ID already bound.");
        } else {
            $user = $this->container->get('bound.user_manager')->add($username, $email, $password, true);
            $client = $user->getClient();

            $client->$setter_id($password);
            $client->$setter_token($response->getAccessToken());

            $this->manager->persist($client);
            $this->manager->flush();

            $this->container->get('bound.notification_manager')->add($user->getPlayer(), "Compte associé", "Vous avez associé votre compte Facebook !", "facebook");

            return $user;
        }
    }

    private function associate(UserResponseInterface $response) {
        $token = $this->session->getFlashBag()->get('token');
        if (array_key_exists(0, $token)) {
            $token = $token[0];
        }

        if ($token != NULL) {
            $token = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Token')->findOneByData($token);
            if ($token instanceof Token) {
                $user = $token->getUser();
                $client = $user->getClient();
                if ($client instanceof Client) {
                    $property = $this->getProperty($response);
                    $username = $response->getUsername();

                    $service = $response->getResourceOwner()->getName();
                    $setter = 'set'.ucfirst($service);

                    $entity = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Client')->findOneBy(array($service.'_id' => $username));
                    if ($entity instanceof Client and $entity != $client) {
                        $this->session->getFlashBag()->add('error', "Client ID already bound.");
                    } else {
                        $setter_id = $setter.'Id';
                        $setter_token = $setter.'AccessToken';

                        $client->$setter_id($username);
                        $client->$setter_token($response->getAccessToken());

                        $this->manager->persist($client);
                        $this->manager->flush();

                        $this->container->get('bound.notification_manager')->add($user->getPlayer(), "Compte associé", "Vous avez associé votre compte Facebook !", "facebook");

                        return $user;
                    }
                } else {
                    $this->session->getFlashBag()->add('error', "Client not found.");
                }
            } else {
                $this->session->getFlashBag()->add('error', "Access Denied.");
            }
        } else {
            $this->session->getFlashBag()->add('error', "Token not found.");
        }
    }
}
