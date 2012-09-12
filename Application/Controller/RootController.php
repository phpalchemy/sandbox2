<?php
namespace Sandbox\Application\Controller;

class RootController extends \Alchemy\Mvc\Controller
{
    /**
     * Index Action for Main controller
     *
     * @view(Root/index)
     */
    public function indexAction()
    {
    }

    /** @view(Root/about) */
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
     * @ServeUi(contact_form = root/register.yaml)
     */
    public function registerAction()
    {
    }
}
