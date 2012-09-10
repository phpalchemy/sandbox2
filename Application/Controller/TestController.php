<?php
namespace Sandbox\Application\Controller;

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
            'data' => array(1, 2, 3)
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

    /** @ServeUi(contact_form = "test/register.yaml") */
    public function registerAction()
    {
    }

    /** @ServeUi(contact_form = "test/register2.yaml", ui-bundle = twitter-bootstrap) */
    public function register2Action()
    {
    }

    /** @ServeUi(contact_form = "test/register2.yaml") */
    public function register3Action()
    {
    }

    /**
     * show contact form
     *
     * @ServeUi(contact_form = "test/contact.ui.xml")
     */
    public function contactAction()
    {
    }

    /**
     * show contact form
     *
     * @View("Test/contact.tpl")
     * @ServeUi(contact_form = "test/contact.ui.xml")
     */
    public function contact1Action()
    {
    }

    /**
     * show contact form 2
     *
     * @ServeUi(sample_form = test/contact2.ui.xml, data = {action = "test/saveContactForm"})
     */
    public function contact2Action()
    {
    }

    /**
     * show contact form
     *
     * @ServeUi(some_form = "test/contact.ui.xml")
     * @ServeUi(data = {action=test/saveContactForm, sample=22, test="hello word"})
     */
    public function contact3Action()
    {
    }

    /**
     * @Request(GET)
     */
    public function onlyGetAction()
    {
        echo 'action that is being displayed "Only" by a request with GET method';
    }

    /**
     * @Request(allow_methods = [GET, POST])
     */
    public function onlyGetAndPostAction()
    {
        echo 'action that is being displayed "Only" by a request with GET method';
    }
}

