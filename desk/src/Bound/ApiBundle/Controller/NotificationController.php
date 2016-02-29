<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-23 11:51:11
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-29 14:02:43
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Notification;

use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializerBuilder;

class NotificationController extends AController {

    /**
     * Mapping [GET] api.bound-app.com/notifications?token="token"
     * @QueryParam(name="token", description="Token de l'utilisateur")
     * @ApiDoc(
     *  description="Retourne la liste de toutes les notifications d'un utilisateur",
     *  output="Bound\CoreBundle\Entity\Notification",
     *  statusCodes={
     *     200="Retourner lorsque tout est OK",
     *     403="Retourner si l'utilisateur n'existe pas ou n'est pas admin"
     *  }
     * )
     */
    public function getNotificationsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $notifications = $this->getDoctrine()->getRepository('BoundCoreBundle:Notification')->findByOwnerByDate($user->getPlayer());

        return array('notifications' => $notifications);
    }
}
