<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("checklst.inc.php");
        use_unit("imglist.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit3 extends Page
        {
               public $ImageList1 = null;
               public $ButtonView1 = null;
               function ButtonView1JSClick($sender, $params)
               {
               ?>
               //Add your javascript code here
               tag=event.getTarget().tag;
               alert("Button Tag ID:" + tag + " clicked");
               <?php

               }
        }

        global $application;

        global $Unit3;

        //Creates the form
        $Unit3=new Unit3($application);

        //Read from resource file
        $Unit3->loadResource(__FILE__);

        //Shows the form
        $Unit3->show();

?>
