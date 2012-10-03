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

    /**
     * @ServeUi(form1="root/form1.yaml")
     */
    public function form1Action()
    {
    }

    /**
     * @ServeUi(form1="root/form1.yaml")
     */
    public function form1EditAction()
    {
        $this->view->form1 = array(
            'textbox1' => 'sample value for textbox1',
            'textbox2' => 'sample value for textbox2',
            'textbox3' => 'sample value for textbox3',
            'listbox1' => 2,
            'listbox2' => array(1, 3),
            'checkbox1' => true,
            'checkgroup1' => array(true, false, true),
            'radiogroup1' => 2
        );
    }
}
