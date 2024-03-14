<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class MasterPage extends Page
        {
               public $pnContents = null;
               public $Panel2 = null;
               public $Panel1 = null;
               function pnContentsShow($sender, $params)
               {
                    //Override this method in inherited pages and show here your contents
               }

        }

        global $application;

        global $MasterPage;

        //Creates the form
        $MasterPage=new MasterPage($application);

        //Read from resource file
        $MasterPage->loadResource(__FILE__);

        //Shows the form
        $MasterPage->show();

?>
