<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-23 11:09:27
 * @Last Modified by:   Kafei59
 * @Last Modified time: 2016-04-19 17:04:51
 */

namespace Bound\CoreBundle\Manager;

use Bound\CoreBundle\Manager\AManager;
use Bound\CoreBundle\Entity\FriendRequest;
use Bound\CoreBundle\Entity\Player;
use Bound\CoreBundle\Globals\FriendRequestType;

use Symfony\Component\HttpKernel\Exception\HttpException;

class FriendsManager extends AManager {

    public function request(Player $from, Player $to) {
        if ($from != $to) {
            if (!$this->alreadyExists($from, $to)) {
                $request = new FriendRequest();

                $request->setFrom($from);
                $request->setTo($to);
                $request->setStatus(FriendRequestType::PENDING);
                $this->pflush($request);

                return $request;
            } else {
                throw new HttpException(409, "FriendRequest already exists");
            }
        } else {
            throw new HttpException(409, "Cannot Friend request same entity");
        }
    }

    private function alreadyExists(Player $from, Player $to) {
        $entity = $this->manager->getRepository('BoundCoreBundle:FriendRequest')->findOneBy(array('from' => $from, 'to' => $to));

        return $entity != NULL;
    }
}
