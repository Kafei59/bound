<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\User;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class UserController extends AController {

    /**
     * Mapping [GET] api.bound-app.com/users?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste de tous les utilisateurs",
     *  output="Bound\CoreBundle\Entity\User",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin"
     *  }
     * )
     */
    public function getUsersAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        if (!$user->isAdmin()) {
            throw new HttpException(403, "Access Denied.");
        }

        $users = $this->getDoctrine()->getRepository('BoundCoreBundle:User')->findAll();

        return array('users' => $users);
    }

    /**
     * Mapping [GET] api.bound-app.com/users/{user}?token="token"
     * @ParamConverter("user", options={"mapping": {"user": "username"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne un utilisateur",
     *  output="Bound\CoreBundle\Entity\User",
     *  requirements={
     *      {
     *          "name"="user",
     *          "dataType"="string",
     *          "description"="Nom d'utilisateur"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin",
     *     404="Retourner si l'utilisateur demandé n'existe pas"
     *  }
     * )
     */
    public function getUserAction(User $user, Request $request) {
        $user = $this->assertToken($request->get('token'));
        if (!$user->isAdmin()) {
            throw new HttpException(403, "Access Denied.");
        }

        return array('user' => $user);
    }
}
