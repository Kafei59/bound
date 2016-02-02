<?php

namespace Bound\CoreBundle\Provider;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass {

    private $container;
    private $manager;

    public function __construct(Container $container, EntityManager $manager, UserManager $userManager, $options) {
        parent::__construct($userManager, $options);

        $this->container = $container;
        $this->manager = $manager;
    }

    public function connect(UserInterface $user, UserResponseInterface $response) {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        $previousUser = $this->userManager->findUserBy(array($property => $username));
        $client = $previous->getClient();
        if ($previousUser != NULL) {
            $client->$setter_id(null);
            $client->$setter_token(null);

            $this->manager->persist($client);
            $this->manager->flush();
        }

        $client->$setter_id($username);
        $client->$setter_token($response->getAccessToken());

        $this->manager->persist($client);
        $this->manager->flush();
    }

    public function loadUserByOAuthUserResponse(UserResponseInterface $response) {
        $username = $response->getRealName();
        $email = $response->getEmail();
        $password = $response->getUsername();

        $user = $this->userManager->findUserByEmail($email);
        if ($user == NULL) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setter_id = $setter.'Id';
            $setter_token = $setter.'AccessToken';

            $user = $this->container->get('bound.user_manager')->add($username, $email, $password);
            $client = $user->getClient();

            $client->$setter_id($username);
            $client->$setter_token($response->getAccessToken());

            $this->manager->persist($client);
            $this->manager->flush();

            return $user;
        } else {
            $user = parent::loadUserByOAuthUserResponse($response);
            $serviceName = $response->getResourceOwner()->getName();
            $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

            $client = $user->getClient();
            $client->$setter($response->getAccessToken());

            return $user;
        }
    }
}
