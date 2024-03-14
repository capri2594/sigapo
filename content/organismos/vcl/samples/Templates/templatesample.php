<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Index extends Page
        {
               public $lbMessage = null;
               public $btnSendContents = null;
               public $RichEdit1 = null;
               function btnSendContentsClick($sender, $params)
               {
                    $this->lbMessage->Caption=html_entity_decode($this->RichEdit1->Text);
                    $this->lbMessage->Visible=true;
               }

        }

        global $application;

        global $Index;

        //Creates the form
        $Index=new Index($application);

        //Read from resource file
        $Index->loadResource(__FILE__);

        //Shows the form
        $Index->show();

?>
