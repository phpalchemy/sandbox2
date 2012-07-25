<?php
namespace Sandbox\Application\Controller;
use \Alchemy\Mvc\Controller;

class MainController extends Controller
{
    /**
     * Index Action for Main controller
     *
     * @view(Main/index.djt)
     */
    public function indexAction()
    {
        return array('title' => 'Hello Word!');
    }
}
