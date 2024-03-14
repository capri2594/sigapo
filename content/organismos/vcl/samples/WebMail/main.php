<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("imglist.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("menus.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit2 extends Page
        {
               public $ListView1 = null;
               public $TreeView1 = null;
               public $ToolBar1 = null;
               public $ImageList1 = null;
               public $MainMenu1 = null;
               function ToolBar1JSClick($sender, $params)
               {

               ?>
               //Add your javascript code here
               alert("toolbar clicked");

               <?php

               }

               function MainMenu1JSClick($sender, $params)
               {

               ?>
               //Add your javascript code here
               alert("menu clicked");
               <?php

               }

               function TreeView1JSClick($sender, $params)
               {
               ?>
               //Add your javascript code here
               alert("tree clicked");
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
