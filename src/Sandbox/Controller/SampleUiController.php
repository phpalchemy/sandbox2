<?php
namespace Sandbox\Controller;

use Alchemy\Mvc\Controller;
use Alchemy\Component\Http\Response;

class SampleUiController extends Controller
{
    /**
     * @view()
     */
    public function indexAction()
    {
    }

    /**
     * @ServeUi(sample_ui/basicForm.yaml)
     * @View()
     */
    public function basicFormAction()
    {
    }

    /**
     * Filling the form with data
     * Note that now we're setting "form1=sample_ui/basicForm.yaml",
     * so we're creating a form that we can pass data
     *
     * @ServeUi(form1=sample_ui/basicForm.yaml)
     * @View()
     */
    public function filledFormAction()
    {
        //
        //NOTE that we're re-using the same meta-ui file "basicForm.yaml"
        // that is the same of Action above
        //

        // Setting data to form named "form1"
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

    /**
     * Example of a login form
     *
     * Note that we're not using a @View() annotation to specify a view template
     * PHPAlchemy supports that :) and the form will be rendered using a layout
     * file named "form_page.twig" bundled in the current layout package
     *
     * @ServeUi(loginForm=sample_ui/login.yaml)
     */
    public function loginAction()
    {
    }

    /**
     * @View()
     */
    public function homeAction($username, $password)
    {
        $params = array('username' => $username, 'password' => $password);

        if ($username == 'admin' && $password == 'admin') {
            $loginSuccess = true;
            $message = 'You are logged successfully!';
        } else {
            $loginSuccess = false;
            $message = 'Login failed!';
        }

        $viewData = array();
        $viewData['message'] = $message;
        $viewData['params'] = print_r($params, true);
        $viewData['login_success'] = $loginSuccess;

        return $viewData;
    }
}
