<?php
namespace Sandbox\Controller;

use Alchemy\Application;
use Alchemy\Mvc\Controller;
use Alchemy\Component\Http\Request;


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
            // Setting data to form with id "basic_form1", that id was set below in @ServeUi annotation
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
     * @ServeUi(loginForm=sample_ui/loginForm.yaml)
     * @View()
     */
    public function loginFormAction()
    {
    }

    /**
     * @View()
     */
    public function homeAction($username, $password)
    {
        $params = array('username' => $username, 'password' => $password);
        $loginSuccess = $username == 'admin' && $password == 'admin';

        if ($loginSuccess) {
            $message = 'You are logged successfully!';
        } else {
            $message = 'Login failed! try with user: admin and password: admin';
        }

        // other way to set variables to view is creating an array, set its data and return it.
        $viewData = array();
        $viewData['message'] = $message;
        $viewData['params'] = print_r($params, true);
        $viewData['login_success'] = $loginSuccess;

        return $viewData;
    }

    /**
     * @ServeUi(table1=sample_ui/list1.yaml)
     * @View()
     */
    public function list1Action(Application $app)
    {
        $data = file($app->getAppDir()."/mixed/example_data.txt");
        $dataList = array("data" => array());

        foreach ($data as $row) {
            $dataList["data"][] = array(
                "lastname" => substr($row, 0, 16),
                "name" => substr($row, 16, 15),
                "rand1" => substr($row, 31,4),
                "rand2" => substr($row, 37, 6),
                "code" => substr($row, 47, 3)
            );
        }

        $this->view->table1 = $dataList;
    }
}
