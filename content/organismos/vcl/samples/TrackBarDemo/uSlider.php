<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit2 extends Page
        {
               public $Label1 = null;
               public $TrackBar1 = null;
               function TrackBar1JSChange($sender, $params)
               {
               ?>
               //Add your javascript code here
               document.getElementById("Label1").innerHTML = "Position : " + document.getElementById("TrackBar1_Position").value
               <?php

               }

        }

        global $application;

        global $Unit2;

        //Creates the form
        $Unit2=new Unit2($application);

        //Read from resource file
        $Unit2->loadResource(__FILE__);

        //Shows the form
        $Unit2->show();

?>
