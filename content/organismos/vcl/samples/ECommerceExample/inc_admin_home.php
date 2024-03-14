<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminHome extends Page
        {
        }

        global $application;

        global $AdminHome;

        //Creates the form
        $AdminHome=new AdminHome($application);

        //Read from resource file
        $AdminHome->loadResource(__FILE__);

        //Shows the form
        $AdminHome->show();

?>
