<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class FrameSample extends Page
        {
               public $Frame3 = null;
               public $Frame2 = null;
               public $Frameset1 = null;
               public $Frame1 = null;

        }

        global $application;

        global $FrameSample;

        //Creates the form
        $FrameSample=new FrameSample($application);

        //Read from resource file
        $FrameSample->loadResource(__FILE__);

        //Shows the form
        $FrameSample->show();

?>
