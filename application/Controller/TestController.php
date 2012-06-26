<?php
namespace Sandbox\Controller;

class TestController extends \Alchemy\Mvc\Controller
{
    /**
     * @View("Test/index.tpl")
     */
    public function indexAction()
    {
    	return array('title' => 'Hello Test');
    }

    /**
     * @Response(Content-Type = "application/json")
     */
    public function getAllAction()
    {
    	$data = array(
    		'success' => true,
    		'data' => array(1,2,3)
    	);

    	echo json_encode($data);
    }

    /**
     * @JsonResponse()
     */
    public function listAction()
    {
    	return array(
    		'success' => true,
    		'data' => array(1,2,3)
    	);
    }
}