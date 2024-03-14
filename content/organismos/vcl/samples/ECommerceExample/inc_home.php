<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class HomePage extends Page
        {
        }

        global $application;

        global $HomePage;

        //Creates the form
        $HomePage=new HomePage($application);

        //Read from resource file
        $HomePage->loadResource(__FILE__);

        //Shows the form
        $HomePage->show();

?>
