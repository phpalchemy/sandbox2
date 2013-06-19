<?php
namespace Sandbox\Application\Controller;

use Alchemy\Mvc\Controller;
use Alchemy\Component\Http\Response;

class TestController extends Controller
{
    /** @ServeUi(contact_form = "test/register.yaml") */
    public function registerAction()
    {
    }

    /** @ServeUi(contact_form="test/register2.yaml", ui-bundle="twitter-bootstrap") */
    public function register2Action()
    {
    }

    /** @ServeUi(contact_form="test/register2.yaml") */
    public function register3Action()
    {
    }

    /** @ServeUi(contact_form="test/register2.yaml", ui-bundle="jquery-mobile") */
    public function register4Action()
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
