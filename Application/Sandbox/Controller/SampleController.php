<?php
namespace Sandbox\Controller;

use Alchemy\Component\Http\Response;

class SampleController extends \Alchemy\Mvc\Controller
{
    /**
     * test passing the template file name to view() annotation (with complete path)
     *
     * @view("Sample/index.twig")
     */
    function indexAction()
    {
        //1st option.- setting controller attribute
        //$this->view->title = 'Hello Word';

        //2nd option.- returning a associative array
        return array('title' => 'Hello Word (smarty)');
    }

    /** @view(Sample/about) */
    public function aboutAction()
    {
    }

    /** @View() */
    public function dataAction($a = '', $b = '')
    {
        $this->view->params = array('a' => $a, 'b' => $b);
    }

    /** @JsonResponse() */
    public function datajsonAction($a = '', $b = '')
    {
        return array('a' => $a, 'b' => $b);
    }

    /**
     * test passing the template file name to view() annotation (without path)
     * it is mapped with controller and action names without suffix
     */
    function testAction()
    {
        return new \Alchemy\Component\Http\Response('<h1>Hello World (Plain)</h1>');
    }

    /**
     * Test passing template name to view() annotation (it is not the same action name)
     *
     * @view("Sample/someTemplate.tpl")
     */
    function test2Action()
    {
        return array('title' => 'Hello Test');
    }

    /**
     * Test passing the template file name to view() annotation (without extension)
     * it is provided by configuration (on application.ini)
     *
     * @view("Sample/someTemplate")
     */
    function test3Action()
    {
        return array('title' => 'Hello Test');
    }

    function helloAction()
    {
        $this->getResponse()->setContent('hello action');
    }

    function action1Action(\Alchemy\Component\Http\Request $request)
    {
        $this->getResponse()->setContent('sample #1 action  - data' . $request->server->get('HTTP_USER_AGENT'));
    }

    function action2Action(\Alchemy\Component\Http\Request $request, $name)
    {
        $this->getResponse()->setContent('sample #2 action - hello ' . $name);
    }

    function action3Action($name, $lastname)
    {
        return new Response('sample #3 action - hello ' . $name . ' ' . $lastname);
    }

    function action4Action($lastname, $name)
    {
        return new Response('sample #4 action - hello ' . $name . ' ' . $lastname);
    }
}
