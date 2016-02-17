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

    public function __construct(Container $container, EntityManager $manager, UserManager $userManager, $options) {
        parent::__construct($userManager, $options);

        $this->container = $container;
        $this->manager = $manager;
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $token = $this->container->get('request')->getSession()->get('token');

        if ($token != NULL) {        
            $token = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Token')->findOneByData($token);
            if ($token instanceof Token) {
                return $this->associate($response, $token->getUser());
            } else {
                throw new HttpException(403, "Access Denied.");
            }
        } else {
            $email = $response->getEmail();

            $user = $this->container->get('doctrine')->getRepository('BoundCoreBundle:User')->findOneByEmail($email);
            if ($user instanceof User) {
                return $user;
            } else {
                return $this->register($response);
            }
        }
    }

    private function associate(UserResponseInterface $response, User $user) {
        $client = $user->getClient();
        if ($client instanceof Client) {
            $property = $this->getProperty($response);
            $username = $response->getUsername();

            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);

            $entity = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Client')->findOneBy(array($service.'_id' => $username));
            if ($entity instanceof Client and $entity != $client) {
                throw new HttpException(409, "Client ID already bound");
            } else {
                $setter_id = $setter.'Id';
                $setter_token = $setter.'AccessToken';

                $client->$setter_id($username);
                $client->$setter_token($response->getAccessToken());

                $this->manager->persist($client);
                $this->manager->flush();

                return $user;
            }
        } else {
            throw new HttpException(404, "Client not found");
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
            throw new HttpException(409, "Client ID already bound.");
        } else {
            $user = $this->container->get('bound.user_manager')->add($username, $email, $password);
            $client = $user->getClient();

            $client->$setter_id($password);
            $client->$setter_token($response->getAccessToken());

            $this->manager->persist($client);
            $this->manager->flush();

            return $user;
        }
    }
}
