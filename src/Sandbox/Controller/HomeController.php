<?php
namespace Sandbox\Controller;

use Alchemy\Application;
use Alchemy\Mvc\Controller;
use Alchemy\Component\Http\Response;

class HomeController extends Controller
{
    /**
     * test passing the template file name to view() annotation (with complete path)
     *
     * @view("home/index.twig")
     */
    function indexAction()
    {
        $a = new \Sandbox\Model\Author();
        $a->setFirstName("erik");
        $a->save();

        die("id: ".$a->getId());

        //1st option.- setting controller attribute
        //$this->view->title = 'Hello Word';

        //2nd option.- returning a associative array
        return array('title' => 'Hello Word (smarty)');
    }

    /** @view(home/about) */
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
     * @view("home/someTemplate.twig")
     */
    function test2Action()
    {
        return array('title' => 'Hello Test');
    }

    /**
     * Test passing the template file name to view() annotation (without extension)
     * it is provided by configuration (on application.ini)
     *
     * @view("home/someTemplate")
     */
    function test3Action()
    {
        return array('title' => 'Hello Test');
    }

    function test4Action(Application $app)
    {
        var_dump($app->getAppDir());
    }

    function test5Action($name, $lastname)
    {
        return new Response('sample #3 action - hello ' . $name . ' ' . $lastname);
    }

    function test6Action($lastname, $name)
    {
        return new Response('sample #4 action - hello ' . $name . ' ' . $lastname);
    }
}
