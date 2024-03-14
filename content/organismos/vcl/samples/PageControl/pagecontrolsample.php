<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit246 extends Page
        {
               public $Button9 = null;
               public $Button8 = null;
               public $Button7 = null;
               public $Button6 = null;
               public $Label4 = null;
               public $ListBox2 = null;
               public $Image4 = null;
               public $Image3 = null;
               public $Label3 = null;
               public $Button5 = null;
               public $Button4 = null;
               public $ComboBox2 = null;
               public $PageControl2 = null;
               public $Window1 = null;
        }

        global $application;

        global $Unit246;

        //Creates the form
        $Unit246=new Unit246($application);

        //Read from resource file
        $Unit246->loadResource(__FILE__);

        //Shows the form
        $Unit246->show();

?>
