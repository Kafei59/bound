<?php
/**
 * @Author: gicque_p
 * @Date:   2015-11-30 19:26:09
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2015-12-11 17:28:21
 */

namespace Bound\CoreBundle\Manager;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Dbal\AclProvider;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

class PManager {

    protected $container;
    protected $manager;
    protected $provider;
    protected $storage;
    protected $um;

    public function __construct(Container $container, EntityManager $manager, AclProvider $provider, TokenStorage $storage, UserManager $um) {
        $this->container = $container;
        $this->manager = $manager;
        $this->provider = $provider;
        $this->storage = $storage;
        $this->um = $um;
    }

    public function persist($object) {
        $this->manager->persist($object);
    }

    public function remove($object) {
        $this->manager->remove($object);
    }

    public function flush() {
        $this->manager->flush();
    }

    public function pflush($object) {
        $this->persist($object);
        $this->flush();
    }

    public function rflush($object) {
        $this->remove($object);
        $this->flush();
    }

    public function persistAcl($object, $token) {
        $user = $this->um->findUserByConfirmationToken($token);
        if ($user instanceof Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken) {
            $objectIdentity = ObjectIdentity::fromDomainObject($object);
            $acl = $this->provider->createAcl($objectIdentity);

            $securityIdentity = UserSecurityIdentity::fromAccount($user);

            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
            $this->provider->updateAcl($acl);
        } else {
            throw new HttpException("403", "Access Denied.");
        }
    }
};
