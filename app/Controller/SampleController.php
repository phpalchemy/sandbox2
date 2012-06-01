<?php
namespace Sandobox\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SampleController //extends \IronG\Mvc\Controller
{
    function indexAction()
    {
        $response = new Response('index action');

        return $response;
    }

    function helloAction()
    {
        $response = new Response('hello action');

        return $response;
    }
}
