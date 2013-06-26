<?php
namespace Sandbox\Application\Controller;

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
     * @ServeUi(SampleUi/basicForm.yaml)
     * @View()
     */
    public function basicFormAction()
    {
    }

    /**
     * Filling the form with data
     * Note that now we're setting "form1=SampleUi/basicForm.yaml", so we're creating a form that we can pass data
     *
     * @ServeUi(form1=SampleUi/basicForm.yaml)
     * @View()
     */
    public function filledFormAction()
    {
        //
        //NOTE that we're re-using the same meta-ui file "basicForm.yaml" at example above
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
     * @View()
     */
    public function saveAction(
        $textbox1,
        $textbox2,
        $textbox3
    ) {
        $formData = array(
            'textbox1' => $textbox1,
            'textbox2' => $textbox2,
            'textbox3' => $textbox3,
        );
        $this->view->form_data = print_r($formData, true);
    }
}
