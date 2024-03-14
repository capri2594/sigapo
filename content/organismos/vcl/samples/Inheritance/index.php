<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("masterpage.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Index extends MasterPage
        {
               public $Label1 = null;
               public $Memo1 = null;
               public $Button1 = null;
               public $pnIndex = null;
               function pnContentsShow($sender, $params)
               {
                    $this->pnIndex->show();
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
