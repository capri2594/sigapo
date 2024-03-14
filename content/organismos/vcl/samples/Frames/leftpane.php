<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class LeftPane extends Page
        {
               public $fdlinks1 = null;
               public $ddlinks1 = null;
               public $dslinks1 = null;
               public $dblinks1 = null;
               public $tblinks1 = null;
               function fdlinks1BeforeShow($sender, $params)
               {               
                        $sender->Link=$this->tblinks1->link_href;
               }


        }

        global $application;

        global $LeftPane;

        //Creates the form
        $LeftPane=new LeftPane($application);

        //Read from resource file
        $LeftPane->loadResource(__FILE__);

        //Shows the form
        $LeftPane->show();

?>
