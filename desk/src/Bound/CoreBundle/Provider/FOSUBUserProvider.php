<?php

namespace Bound\CoreBundle\Provider;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Client;

class FOSUBUserProvider extends BaseClass {

    private $container;
    private $manager;

    public function __construct(Container $container, EntityManager $manager, UserManager $userManager, $options) {
        parent::__construct($userManager, $options);

        $this->container = $container;
        $this->manager = $manager;
    }

    // public function connect(UserInterface $user, UserResponseInterface $response) {
    //     $property = $this->getProperty($response);
    //     $username = $response->getUsername();

    //     $service = $response->getResourceOwner()->getName();
    //     $setter = 'set'.ucfirst($service);
    //     $setter_id = $setter.'Id';
    //     $setter_token = $setter.'AccessToken';

    //     $previousUser = $this->userManager->findUserByUsername($username);

    //     if ($previousUser != NULL) {
    //         $client = $previousUser->getClient();
    //         $client->$setter_id($username);
    //         $client->$setter_token($response->getAccessToken());

    //         $this->manager->persist($client);
    //         $this->manager->flush();
    //     }
    // }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $email = $response->getEmail();

        $user = $this->userManager->findUserByEmail($email);
        if ($user instanceof User) {
            return $this->login($response, $user);
        } else {
            return $this->register($response);
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

        $client = $this->container->get('doctrine')->getRepository('BoundCoreBundle:Client')->findOneBy(array('facebook_id' => $password));
        if ($client instanceof Client) {
            throw new Exception(409, "Account already exists");
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

    private function login(UserResponseInterface $response, User $user) {
        $client = $user->getClient();
        if ($client instanceof Client) {
            $property = $this->getProperty($response);
            $username = $response->getUsername();

            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';

            $client->$setter_id($username);
            $client->$setter_token($response->getAccessToken());

            $this->manager->persist($client);
            $this->manager->flush();

            return $user;
        } else {
            throw new Exception(404, "Client not found");
        }
    }
}
