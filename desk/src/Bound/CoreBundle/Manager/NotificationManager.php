<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-23 11:09:27
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-23 12:21:24
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\AManager;
use Bound\CoreBundle\Entity\Notification;
use Bound\CoreBundle\Entity\Player;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotificationManager extends AManager {

    public function add(Player $owner, $title, $content, $type) {
        $notification = new Notification();

        $notification->setOwner($owner);
        $notification->setTitle($title);
        $notification->setContent($content);
        $notification->setType($type);
        $notification->setDate(new \Datetime('now'));
        $this->pflush($notification);

        return $notification;
    }

    public function edit(Notification $notification) {
        $this->pflush($notification);

        return $notification;
    }

    public function delete(Notification $notification) {
        $this->rflush($notification);
    }
}
