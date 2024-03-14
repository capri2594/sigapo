<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Logout extends Page
        {
            function LogoutCreate($sender, $params)
            {

            }

        }

        global $application;

        global $Logout;

        //Creates the form
        $Logout=new Logout($application);

        //Read from resource file
        $Logout->loadResource(__FILE__);

        //Shows the form
        $Logout->show();

?>
