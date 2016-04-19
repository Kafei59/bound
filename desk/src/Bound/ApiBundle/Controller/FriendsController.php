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

use Bound\CoreBundle\Entity\FriendRequest;
use Bound\CoreBundle\Entity\Player;

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
     * Mapping [GET] api.bound-app.com/friends/request?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste des demandes d'amis de l'utilisateur",
     *  output="Bound\CoreBundle\Entity\FriendRequest",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas",
     *  }
     * )
     */
    public function getFriendsRequestAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $player = $user->getPlayer();
        $requests = $this->getDoctrine()->getRepository("BoundCoreBundle:FriendRequest")->findAllRequests($player);

        return array('requests' => $requests);
    }

    /**
     * Mapping [GET] api.bound-app.com/friends/request/{player}?token="token"
     * @ParamConverter("player", options={"mapping": {"player": "playername"}})
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @Get("/friends/request/{player}")
     * @ApiDoc(
     *  description="Crée une demande d'ami",
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
    public function requestAction(Player $player, Request $request) {
        $user = $this->assertToken($request->get('token'));
        $entity = $user->getPlayer();

        $request = $this->get('bound.friends_manager')->request($entity, $player);

        return array('request' => $request);
    }
}
