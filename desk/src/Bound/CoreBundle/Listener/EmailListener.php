<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-15 14:43:54
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-15 14:51:59
 */

namespace Bound\CoreBundle\Listener;

use Symfony\Component\DependencyInjection\Container;

class EmailListener {

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function send($subject, $from, $to, $body) {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body, 'text/html')
        ;

        $this->container->get('mailer')->send($message);
    }
}
