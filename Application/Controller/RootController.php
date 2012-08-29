<?php
namespace Sandbox\Application\Controller;

use Alchemy\Mvc\Controller;

class RootController extends Controller
{
    /**
     * Index Action for Main controller
     *
     * @view(Root/index)
     */
    public function indexAction()
    {
        return array('title' => 'Welcome to PhpAlchemy Project v1.0!');
    }

    /** @view(Root/about) */
    public function aboutAction()
    {
        $this->view->text = 'sample action this project';
    }

    /** @view() */
    public function sampleAction()
    {
        $this->view->text = 'sample action';
    }

}
