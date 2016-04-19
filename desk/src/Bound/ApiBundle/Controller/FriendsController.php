<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class FriendsController extends AController {

    /**
     * Mapping [GET] api.bound-app.com/friends?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste de tous les amis de l'utilisateur",
     *  output="Bound\CoreBundle\Entity\Player",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas"
     *  }
     * )
     */
    public function getFriendsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $friends = $user->getPlayer()->getFriends();

        return array('friends' => $friends);
    }

    /**
     * Mapping [POST] api.bound-app.com/friends?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @Post("/friends")
     * @ApiDoc(
     *  description="Fait une demande d'ami",
     *  output="Bound\CoreBundle\Entity\FriendRequest",
     *  requirements={
     *      {
     *          "name"="player",
     *          "dataType"="string",
     *          "description"="Nom de l'utilisateur"
     *      }
     *  },
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas",
     *     404="Retrouner si l'utilisateur recherché n'existe pas",
     *     409="Retrouner si l'utilisateur est déjà ami ou si la demande a été refusé"
     *  }
     * )
     */
    public function requestAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $from = $user->getPlayer();

        $playername = $request->get('player');
        $to = $this->getDoctrine()->getRepository('BoundCoreBundle:Player')->findOneByPlayername($playername);

        return array('to' => $to);
    }
}
