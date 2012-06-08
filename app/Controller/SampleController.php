<?php
namespace Sandbox\Controller;

class SampleController extends \IronG\Mvc\Controller
{
    /**
     * @view(sample/index.tpl)
     */
    function indexAction()
    {
        $response = new Response('index action');

        return $response;
    }

    function helloAction()
    {
        $this->response->setContent('hello action');
    }

    function action1Action(\IronG\Net\Http\Request $request)
    {
        $this->response->setContent('sample #1 action  - data' . $request->server->get('HTTP_USER_AGENT'));
    }

    function action2Action(\IronG\Net\Http\Request $request, $name)
    {
        $this->response->setContent('sample #2 action - hello ' . $name);
    }

    function action3Action($name, $lastname)
    {
        $this->response->setContent('sample #3 action - hello ' . $name . ' ' . $lastname);
    }

    function action4Action($lastname, $name)
    {
        $this->response->setContent('sample #4 action - hello ' . $name . ' ' . $lastname);
    }
}
