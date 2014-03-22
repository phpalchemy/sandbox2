<?php
namespace Sandbox\Controller;

use Alchemy\Component\Http\Request;
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
     * We can fill the form with data and submit it
     * Note that we're setting "basic_form1=sample_ui/basicForm.yaml",
     * so we're creating a form with id "basic_form1" and we can pass data to it
     *
     * @ServeUi(basic_form1=sample_ui/basicForm.yaml)
     * @View()
     */
    public function basicFormAction(Request $httpRequest)
    {
        if (! empty($httpRequest->request->data)) {
            // Setting data to form with id "basic_form1"
            $this->view->basic_form1 = $httpRequest->request->data;
            $this->view->postData = print_r($httpRequest->request->data, true);
        }
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
