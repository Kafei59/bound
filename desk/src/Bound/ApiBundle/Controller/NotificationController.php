<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-23 11:51:11
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 16:43:50
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Bound\ApiBundle\Controller\AController;
use Bound\CoreBundle\Entity\Notification;

use JMS\Serializer\SerializerBuilder;

class NotificationController extends AController {

    /**
     * Mapping [GET] /api/notifications
     */
    public function getNotificationsAction(Request $request) {
        $user = $this->assertToken($request->get('token'));
        $notifications = $this->getDoctrine()->getRepository('BoundCoreBundle:Notification')->findByOwnerByDate($user->getPlayer());

        return array('notifications' => $notifications);
    }
}
