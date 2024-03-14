<?php
        //Includes
        require_once("wcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Noname1 extends Page
        {
        }

        global $application;

        global $Noname1;

        //Creates the form
        $Noname1=new Noname1($application);

        //Read from resource file
        $Noname1->loadResource(__FILE__);

        //Shows the form
        $Noname1->show();

?>
