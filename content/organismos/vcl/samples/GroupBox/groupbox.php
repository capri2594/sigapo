<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("buttons.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class GroupBoxSample extends Page
        {
               public $Edit1 = null;
               public $BitBtn2 = null;
               public $BitBtn1 = null;
               public $Memo1 = null;
               public $Label1 = null;
               public $Button1 = null;
               public $GroupBox1 = null;
        }

        global $application;

        global $GroupBoxSample;

        //Creates the form
        $GroupBoxSample=new GroupBoxSample($application);

        //Read from resource file
        $GroupBoxSample->loadResource(__FILE__);

        //Shows the form
        $GroupBoxSample->show();

?>
