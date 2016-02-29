<?php
/**
 * @Author: gicque_p
 * @Date:   2015-12-31 17:06:33
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-29 14:12:34
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\User;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Entity\Client;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Post;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class SecurityController extends AController {

    /**
     * Mapping [POST] api.bound-app.com/login"
     * @Post("/login")
     * @ApiDoc(
     *  description="Connexion à l'application",
     *  output="Bound\CoreBundle\Entity\Token",
     *  parameters={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "description"="Nom d'utilisateur ou email",
     *          "required"="true"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "description"="Mot de passe en clair",
     *          "required"="true"
     *      }
     *     
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     400="Retourner si le nom d'utilisateur ou l'email n'existe pas",
     *     403="Retourner si le mot de passe est incorrect ou si l'adresse mail n'est pas vérifiée",
     *  }
     * )
     */
    public function loginAction(Request $request) {
        $username = $request->get('username');
        $password = $request->get('password');

        $fum = $this->container->get('fos_user.user_manager');
        $user = $fum->findUserByUsername($username);

        if (!$user) {
            $user = $fum->findUserByEmail($username);
        }

        if (!$user instanceof User) {
            throw new HttpException(400, "User not found.");
        }

        if (!$this->checkUserPassword($user, $password)) {
            throw new HttpException(403, "Wrong credentials.");
        }

        if (!$user->isEnabled()) {
            throw new HttpException(403, "Email not checked.");
        }

        $token = $this->getDoctrine()->getRepository('BoundCoreBundle:Token')->findOneByUser($user);
        if (!$token) {
            $token = $this->get('bound.token_manager')->add($user);
        }

        return array('token' => $token);
    }

    /**
     * Mapping [POST] api.bound-app.com/register"
     * @Post("/register")
     * @ApiDoc(
     *  description="Inscription à l'application",
     *  output="array",
     *  parameters={
     *      {
     *          "name"="username",
     *          "dataType"="string",
     *          "description"="Nom d'utilisateur",
     *          "required"="true"
     *      },
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "description"="Email",
     *          "required"="true"
     *      },
     *      {
     *          "name"="password",
     *          "dataType"="string",
     *          "description"="Mot de passe en clair",
     *          "required"="true"
     *      }
     *     
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     409="Retourner si le nom d'utilisateur ou l'email existe déjà"
     *  }
     * )
     */
    public function registerAction(Request $request) {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');

        if ($username and $email and $password) {
            $this->get('bound.user_manager')->add($username, $email, $password);

            return array("Email sent to ".$email.".");
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }

    /**
     * Mapping [POST] api.bound-app.com/resetting"
     * @Post("/resetting")
     * @ApiDoc(
     *  description="Oubli de mot de passe",
     *  output="array",
     *  parameters={
     *      {
     *          "name"="email",
     *          "dataType"="string",
     *          "description"="Email",
     *          "required"="true"
     *      }
     *     
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     400="Retourner si l'utilisateur n'existe pas ou que la requête a déjà été faite"
     *  }
     * )
     */
    public function resettingAction(Request $request) {
        $email = $request->get('email');

        if ($email) {
            $this->get('bound.user_manager')->changePassword($email);

            return array("Email sent to ".$email.".");
        } else {
            throw new HttpException(400, "Bad Request.");
        }
    }


    private function checkUserPassword(User $user, $password) {
        $factory = $this->container->get('security.encoder_factory');
        $encoder = $factory->getEncoder($user);

        if (!$encoder) {
            return false;
        } else {
            return $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
        }
    }
}
