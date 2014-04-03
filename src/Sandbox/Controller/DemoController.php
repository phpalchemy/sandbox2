<?php
namespace Sandbox\Controller;

use Alchemy\Application;
use Alchemy\Mvc\Controller;
use Alchemy\Component\Http;


class DemoController extends Controller
{
    /**
     * @view()
     */
    public function indexAction()
    {
    }

    /**
     * @ServeUi(basic_form1=demo/basicForm.yaml)
     * @View()
     */
    public function basicFormAction()
    {
    }

    /**
     * We can fill the form with data and submit it
     * Note that we're setting "basic_form1=demo/basicForm.yaml",
     * so we're creating a form with id "basic_form1" and we can pass data to it
     *
     * @ServeUi(basic_form1=demo/basicForm.yaml)
     * @View()
     */
    public function saveBasicFormAction(Http\Request $httpRequest)
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
     * @ServeUi(loginForm=demo/loginForm.yaml)
     * @View()
     */
    public function loginFormAction()
    {
    }

    /**
     * @View()
     */
    public function loginHomeAction($username, $password)
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
     * @ServeUi(list1=demo/list1.yaml)
     * @View()
     */
    public function list1Action()
    {
        $data = array("data" => self::getDemoData());
        $this->view->list1 = $data;
    }

    /**
     * @ServeUi(list2=demo/list2.yaml)
     * @View()
     */
    public function list2Action()
    {
    }

    /**
     * @ServeUi(demo/employeesList.yaml)
     * @View()
     */
    public function employeesListAction()
    {
    }

    /**
     * @JsonResponse()
     */
    public function getDataAction()
    {
        return array("data" => self::getDemoData());
    }

    /**
     * @JsonResponse()
     */
    public function employeesDataAction(Http\Request $httpRequest)
    {
        $start = $httpRequest->query->get("start", 0);
        $limit = $httpRequest->query->get("limit", 10);

        $data["data"] = self::getDemoData();
        $data["recordsTotal"] = count($data["data"]);
        $data["recordsFiltered"] = count($data["data"]);
        $data["data"] = array_slice($data["data"], $start, $limit);

        return $data;
    }

    /**
     * @serveUi(authors_list=demo/authors.yaml)
     * @view()
     */
    public function authorsAction()
    {
        $authors = \Sandbox\Model\AuthorQuery::create()->find()->toArray(null, false, \Propel\Runtime\Map\TableMap::TYPE_FIELDNAME);

        $this->view->authors_list = array("data" => $authors);
    }

    /**
     * @serveUi(demo/author.yaml)
     * @view()
     */
    public function authorAction()
    {
    }

    public function saveAuthorAction($first_name, $last_name)
    {
        $author = new \Sandbox\Model\Author();
        $author->setFirstName($first_name);
        $author->setLastName($last_name);
        $author->save();

        $response = new Http\Response("", 200, array("location"=>"/demo/authors"));
        $response->send();

        return $response;
    }

    /** @view() */
    public function viewCodeAction($target, Application $app)
    {
        $target = \Alchemy\Util\String::toCamelCase($target, true);
        $metaUiFile = "/views/meta/demo/$target.yaml";

        $reflector = new \ReflectionClass(__CLASS__);
        $func = $reflector->getMethod($target."Action");
        $filename = $func->getFileName();
        $start_line = $func->getStartLine() - 5;
        $end_line = $func->getEndLine();
        $length = $end_line - $start_line;
        $source = file($filename);

        $this->view->controllerMethod = __CLASS__."::".$target."()";
        $this->view->controllerCode = implode("", array_slice($source, $start_line, $length));

        if (file_exists($app->getAppDir().$metaUiFile)) {
            $this->view->metaUiFile = $metaUiFile;
            $this->view->metaUiCode = file_get_contents($app->getAppDir().$metaUiFile);
        }
    }

    /* Private function just used in examples */
    private static function getDemoData()
    {
        return array (
            0 =>
                array (
                    'name' => 'Tiger Nixon',
                    'position' => 'System Architect',
                    'salary' => '$320,800',
                    'start_date' => '2011/04/25',
                    'office' => 'Edinburgh',
                    'extn' => '5421',
                ),
            1 =>
                array (
                    'name' => 'Garrett Winters',
                    'position' => 'Accountant',
                    'salary' => '$170,750',
                    'start_date' => '2011/07/25',
                    'office' => 'Tokyo',
                    'extn' => '8422',
                ),
            2 =>
                array (
                    'name' => 'Ashton Cox',
                    'position' => 'Junior Technical Author',
                    'salary' => '$86,000',
                    'start_date' => '2009/01/12',
                    'office' => 'San Francisco',
                    'extn' => '1562',
                ),
            3 =>
                array (
                    'name' => 'Cedric Kelly',
                    'position' => 'Senior Javascript Developer',
                    'salary' => '$433,060',
                    'start_date' => '2012/03/29',
                    'office' => 'Edinburgh',
                    'extn' => '6224',
                ),
            4 =>
                array (
                    'name' => 'Airi Satou',
                    'position' => 'Accountant',
                    'salary' => '$162,700',
                    'start_date' => '2008/11/28',
                    'office' => 'Tokyo',
                    'extn' => '5407',
                ),
            5 =>
                array (
                    'name' => 'Brielle Williamson',
                    'position' => 'Integration Specialist',
                    'salary' => '$372,000',
                    'start_date' => '2012/12/02',
                    'office' => 'New York',
                    'extn' => '4804',
                ),
            6 =>
                array (
                    'name' => 'Herrod Chandler',
                    'position' => 'Sales Assistant',
                    'salary' => '$137,500',
                    'start_date' => '2012/08/06',
                    'office' => 'San Francisco',
                    'extn' => '9608',
                ),
            7 =>
                array (
                    'name' => 'Rhona Davidson',
                    'position' => 'Integration Specialist',
                    'salary' => '$327,900',
                    'start_date' => '2010/10/14',
                    'office' => 'Tokyo',
                    'extn' => '6200',
                ),
            8 =>
                array (
                    'name' => 'Colleen Hurst',
                    'position' => 'Javascript Developer',
                    'salary' => '$205,500',
                    'start_date' => '2009/09/15',
                    'office' => 'San Francisco',
                    'extn' => '2360',
                ),
            9 =>
                array (
                    'name' => 'Sonya Frost',
                    'position' => 'Software Engineer',
                    'salary' => '$103,600',
                    'start_date' => '2008/12/13',
                    'office' => 'Edinburgh',
                    'extn' => '1667',
                ),
            10 =>
                array (
                    'name' => 'Jena Gaines',
                    'position' => 'Office Manager',
                    'salary' => '$90,560',
                    'start_date' => '2008/12/19',
                    'office' => 'London',
                    'extn' => '3814',
                ),
            11 =>
                array (
                    'name' => 'Quinn Flynn',
                    'position' => 'Support Lead',
                    'salary' => '$342,000',
                    'start_date' => '2013/03/03',
                    'office' => 'Edinburgh',
                    'extn' => '9497',
                ),
            12 =>
                array (
                    'name' => 'Charde Marshall',
                    'position' => 'Regional Director',
                    'salary' => '$470,600',
                    'start_date' => '2008/10/16',
                    'office' => 'San Francisco',
                    'extn' => '6741',
                ),
            13 =>
                array (
                    'name' => 'Haley Kennedy',
                    'position' => 'Senior Marketing Designer',
                    'salary' => '$313,500',
                    'start_date' => '2012/12/18',
                    'office' => 'London',
                    'extn' => '3597',
                ),
            14 =>
                array (
                    'name' => 'Tatyana Fitzpatrick',
                    'position' => 'Regional Director',
                    'salary' => '$385,750',
                    'start_date' => '2010/03/17',
                    'office' => 'London',
                    'extn' => '1965',
                ),
            15 =>
                array (
                    'name' => 'Michael Silva',
                    'position' => 'Marketing Designer',
                    'salary' => '$198,500',
                    'start_date' => '2012/11/27',
                    'office' => 'London',
                    'extn' => '1581',
                ),
            16 =>
                array (
                    'name' => 'Paul Byrd',
                    'position' => 'Chief Financial Officer (CFO)',
                    'salary' => '$725,000',
                    'start_date' => '2010/06/09',
                    'office' => 'New York',
                    'extn' => '3059',
                ),
            17 =>
                array (
                    'name' => 'Gloria Little',
                    'position' => 'Systems Administrator',
                    'salary' => '$237,500',
                    'start_date' => '2009/04/10',
                    'office' => 'New York',
                    'extn' => '1721',
                ),
            18 =>
                array (
                    'name' => 'Bradley Greer',
                    'position' => 'Software Engineer',
                    'salary' => '$132,000',
                    'start_date' => '2012/10/13',
                    'office' => 'London',
                    'extn' => '2558',
                ),
            19 =>
                array (
                    'name' => 'Dai Rios',
                    'position' => 'Personnel Lead',
                    'salary' => '$217,500',
                    'start_date' => '2012/09/26',
                    'office' => 'Edinburgh',
                    'extn' => '2290',
                ),
            20 =>
                array (
                    'name' => 'Jenette Caldwell',
                    'position' => 'Development Lead',
                    'salary' => '$345,000',
                    'start_date' => '2011/09/03',
                    'office' => 'New York',
                    'extn' => '1937',
                ),
            21 =>
                array (
                    'name' => 'Yuri Berry',
                    'position' => 'Chief Marketing Officer (CMO)',
                    'salary' => '$675,000',
                    'start_date' => '2009/06/25',
                    'office' => 'New York',
                    'extn' => '6154',
                ),
            22 =>
                array (
                    'name' => 'Caesar Vance',
                    'position' => 'Pre-Sales Support',
                    'salary' => '$106,450',
                    'start_date' => '2011/12/12',
                    'office' => 'New York',
                    'extn' => '8330',
                ),
            23 =>
                array (
                    'name' => 'Doris Wilder',
                    'position' => 'Sales Assistant',
                    'salary' => '$85,600',
                    'start_date' => '2010/09/20',
                    'office' => 'Sidney',
                    'extn' => '3023',
                ),
            24 =>
                array (
                    'name' => 'Angelica Ramos',
                    'position' => 'Chief Executive Officer (CEO)',
                    'salary' => '$1,200,000',
                    'start_date' => '2009/10/09',
                    'office' => 'London',
                    'extn' => '5797',
                ),
            25 =>
                array (
                    'name' => 'Gavin Joyce',
                    'position' => 'Developer',
                    'salary' => '$92,575',
                    'start_date' => '2010/12/22',
                    'office' => 'Edinburgh',
                    'extn' => '8822',
                ),
            26 =>
                array (
                    'name' => 'Jennifer Chang',
                    'position' => 'Regional Director',
                    'salary' => '$357,650',
                    'start_date' => '2010/11/14',
                    'office' => 'Singapore',
                    'extn' => '9239',
                ),
            27 =>
                array (
                    'name' => 'Brenden Wagner',
                    'position' => 'Software Engineer',
                    'salary' => '$206,850',
                    'start_date' => '2011/06/07',
                    'office' => 'San Francisco',
                    'extn' => '1314',
                ),
            28 =>
                array (
                    'name' => 'Fiona Green',
                    'position' => 'Chief Operating Officer (COO)',
                    'salary' => '$850,000',
                    'start_date' => '2010/03/11',
                    'office' => 'San Francisco',
                    'extn' => '2947',
                ),
            29 =>
                array (
                    'name' => 'Shou Itou',
                    'position' => 'Regional Marketing',
                    'salary' => '$163,000',
                    'start_date' => '2011/08/14',
                    'office' => 'Tokyo',
                    'extn' => '8899',
                ),
            30 =>
                array (
                    'name' => 'Michelle House',
                    'position' => 'Integration Specialist',
                    'salary' => '$95,400',
                    'start_date' => '2011/06/02',
                    'office' => 'Sidney',
                    'extn' => '2769',
                ),
            31 =>
                array (
                    'name' => 'Suki Burks',
                    'position' => 'Developer',
                    'salary' => '$114,500',
                    'start_date' => '2009/10/22',
                    'office' => 'London',
                    'extn' => '6832',
                ),
            32 =>
                array (
                    'name' => 'Prescott Bartlett',
                    'position' => 'Technical Author',
                    'salary' => '$145,000',
                    'start_date' => '2011/05/07',
                    'office' => 'London',
                    'extn' => '3606',
                ),
            33 =>
                array (
                    'name' => 'Gavin Cortez',
                    'position' => 'Team Leader',
                    'salary' => '$235,500',
                    'start_date' => '2008/10/26',
                    'office' => 'San Francisco',
                    'extn' => '2860',
                ),
            34 =>
                array (
                    'name' => 'Martena Mccray',
                    'position' => 'Post-Sales support',
                    'salary' => '$324,050',
                    'start_date' => '2011/03/09',
                    'office' => 'Edinburgh',
                    'extn' => '8240',
                ),
            35 =>
                array (
                    'name' => 'Unity Butler',
                    'position' => 'Marketing Designer',
                    'salary' => '$85,675',
                    'start_date' => '2009/12/09',
                    'office' => 'San Francisco',
                    'extn' => '5384',
                ),
            36 =>
                array (
                    'name' => 'Howard Hatfield',
                    'position' => 'Office Manager',
                    'salary' => '$164,500',
                    'start_date' => '2008/12/16',
                    'office' => 'San Francisco',
                    'extn' => '7031',
                ),
            37 =>
                array (
                    'name' => 'Hope Fuentes',
                    'position' => 'Secretary',
                    'salary' => '$109,850',
                    'start_date' => '2010/02/12',
                    'office' => 'San Francisco',
                    'extn' => '6318',
                ),
            38 =>
                array (
                    'name' => 'Vivian Harrell',
                    'position' => 'Financial Controller',
                    'salary' => '$452,500',
                    'start_date' => '2009/02/14',
                    'office' => 'San Francisco',
                    'extn' => '9422',
                ),
            39 =>
                array (
                    'name' => 'Timothy Mooney',
                    'position' => 'Office Manager',
                    'salary' => '$136,200',
                    'start_date' => '2008/12/11',
                    'office' => 'London',
                    'extn' => '7580',
                ),
            40 =>
                array (
                    'name' => 'Jackson Bradshaw',
                    'position' => 'Director',
                    'salary' => '$645,750',
                    'start_date' => '2008/09/26',
                    'office' => 'New York',
                    'extn' => '1042',
                ),
            41 =>
                array (
                    'name' => 'Olivia Liang',
                    'position' => 'Support Engineer',
                    'salary' => '$234,500',
                    'start_date' => '2011/02/03',
                    'office' => 'Singapore',
                    'extn' => '2120',
                ),
            42 =>
                array (
                    'name' => 'Bruno Nash',
                    'position' => 'Software Engineer',
                    'salary' => '$163,500',
                    'start_date' => '2011/05/03',
                    'office' => 'London',
                    'extn' => '6222',
                ),
            43 =>
                array (
                    'name' => 'Sakura Yamamoto',
                    'position' => 'Support Engineer',
                    'salary' => '$139,575',
                    'start_date' => '2009/08/19',
                    'office' => 'Tokyo',
                    'extn' => '9383',
                ),
            44 =>
                array (
                    'name' => 'Thor Walton',
                    'position' => 'Developer',
                    'salary' => '$98,540',
                    'start_date' => '2013/08/11',
                    'office' => 'New York',
                    'extn' => '8327',
                ),
            45 =>
                array (
                    'name' => 'Finn Camacho',
                    'position' => 'Support Engineer',
                    'salary' => '$87,500',
                    'start_date' => '2009/07/07',
                    'office' => 'San Francisco',
                    'extn' => '2927',
                ),
            46 =>
                array (
                    'name' => 'Serge Baldwin',
                    'position' => 'Data Coordinator',
                    'salary' => '$138,575',
                    'start_date' => '2012/04/09',
                    'office' => 'Singapore',
                    'extn' => '8352',
                ),
            47 =>
                array (
                    'name' => 'Zenaida Frank',
                    'position' => 'Software Engineer',
                    'salary' => '$125,250',
                    'start_date' => '2010/01/04',
                    'office' => 'New York',
                    'extn' => '7439',
                ),
            48 =>
                array (
                    'name' => 'Zorita Serrano',
                    'position' => 'Software Engineer',
                    'salary' => '$115,000',
                    'start_date' => '2012/06/01',
                    'office' => 'San Francisco',
                    'extn' => '4389',
                ),
            49 =>
                array (
                    'name' => 'Jennifer Acosta',
                    'position' => 'Junior Javascript Developer',
                    'salary' => '$75,650',
                    'start_date' => '2013/02/01',
                    'office' => 'Edinburgh',
                    'extn' => '3431',
                ),
            50 =>
                array (
                    'name' => 'Cara Stevens',
                    'position' => 'Sales Assistant',
                    'salary' => '$145,600',
                    'start_date' => '2011/12/06',
                    'office' => 'New York',
                    'extn' => '3990',
                ),
            51 =>
                array (
                    'name' => 'Hermione Butler',
                    'position' => 'Regional Director',
                    'salary' => '$356,250',
                    'start_date' => '2011/03/21',
                    'office' => 'London',
                    'extn' => '1016',
                ),
            52 =>
                array (
                    'name' => 'Lael Greer',
                    'position' => 'Systems Administrator',
                    'salary' => '$103,500',
                    'start_date' => '2009/02/27',
                    'office' => 'London',
                    'extn' => '6733',
                ),
            53 =>
                array (
                    'name' => 'Jonas Alexander',
                    'position' => 'Developer',
                    'salary' => '$86,500',
                    'start_date' => '2010/07/14',
                    'office' => 'San Francisco',
                    'extn' => '8196',
                ),
            54 =>
                array (
                    'name' => 'Shad Decker',
                    'position' => 'Regional Director',
                    'salary' => '$183,000',
                    'start_date' => '2008/11/13',
                    'office' => 'Edinburgh',
                    'extn' => '6373',
                ),
            55 =>
                array (
                    'name' => 'Michael Bruce',
                    'position' => 'Javascript Developer',
                    'salary' => '$183,000',
                    'start_date' => '2011/06/27',
                    'office' => 'Singapore',
                    'extn' => '5384',
                ),
            56 =>
                array (
                    'name' => 'Donna Snider',
                    'position' => 'Customer Support',
                    'salary' => '$112,000',
                    'start_date' => '2011/01/25',
                    'office' => 'New York',
                    'extn' => '4226',
                ),

        );
    }
}

