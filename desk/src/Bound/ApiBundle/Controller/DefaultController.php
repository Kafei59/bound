<?php
/**
 * @Author: gicque_p
 * @Date:   2016-02-19 13:59:43
 * @Last Modified by:   gicque_p
 * @Last Modified time: 2016-02-19 14:02:27
 */

namespace Bound\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {

    public function indexAction() {
        return $this->render('BoundApiBundle::index.html.twig');
    }
}
