<?php

namespace Bound\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('BoundApiBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showAction($title, $content, $author) {
        $array = array('response' => "200", 'data' => array('title' => $title, 'content' => $content, 'author' => $author));
        $response = new Response(json_encode($array, JSON_PRETTY_PRINT));
        $response->headers->set('Content-Type', 'application/json');

        return $response; 
    }
}
