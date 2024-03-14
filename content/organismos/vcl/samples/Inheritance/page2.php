<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("masterpage.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Page2 extends MasterPage
        {
               public $RichEdit1 = null;
               public $Panel11 = null;
               function pnContentsShow($sender, $params)
               {
                    $this->Panel11->show();
               }
        }

        global $application;

        global $Page2;

        //Creates the form
        $Page2=new Page2($application);

        //Read from resource file
        $Page2->loadResource(__FILE__);

        //Shows the form
        $Page2->show();

?>
