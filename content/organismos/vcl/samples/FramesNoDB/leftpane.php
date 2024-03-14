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
               public $Label2 = null;
               public $Label1 = null;
               public $lbLink1 = null;
               public $Panel1 = null;


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
