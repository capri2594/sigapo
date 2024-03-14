<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class WindowSample extends Page
        {
               public $Button2 = null;
               public $wm2 = null;
               public $Button1 = null;
               public $Edit1 = null;
               public $Label1 = null;
               public $ddEMPLOYEE1 = null;
               public $dsEMPLOYEE1 = null;
               public $dbEMPLOYEE1 = null;
               public $tbEMPLOYEE1 = null;
               public $wm1 = null;
               function Button2JSClick($sender, $params)
               {               
               ?>
               //Add your javascript code here
                wm2.close();
               <?php
               }

               function Button1JSClick($sender, $params)
               {               
               ?>
               //Add your javascript code here
                        wm2.show();
               <?php
               }

        }

        global $application;

        global $WindowSample;

        //Creates the form
        $WindowSample=new WindowSample($application);

        //Read from resource file
        $WindowSample->loadResource(__FILE__);

        //Shows the form
        $WindowSample->show();

?>
