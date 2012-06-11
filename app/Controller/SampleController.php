<?php
namespace Sandbox\Controller;

class SampleController extends \Alchemy\Mvc\Controller
{
    /**
     * @view("sample/index.tpl")
     */
    function indexAction()
    {
        //1st option.- setting controller attribute 'view'
        //$this->view->title = 'Hello Word 1';

        //2nd option.- returning a associative array
        return array('title' => 'Hello Word 2');
    }

    function helloAction()
    {
        $this->response->setContent('hello action');
    }

    function action1Action(\Alchemy\Net\Http\Request $request)
    {
        $this->response->setContent('sample #1 action  - data' . $request->server->get('HTTP_USER_AGENT'));
    }

    function action2Action(\Alchemy\Net\Http\Request $request, $name)
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
