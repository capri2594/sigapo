<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit1 extends Page
        {
               public $DBPaginator1 = null;
               public $DBGrid1 = null;
               public $DatasourceTOrganismo = null;
               public $TableOrganismo = null;
               public $DatabaseSIRC = null;
               function DBGrid1JSDblClick($sender, $params)
               {

               ?>
               //Add your javascript code here

               <?php

               }


        }

        global $application;

        global $Unit1;

        //Creates the form
        $Unit1=new Unit1($application);

        //Read from resource file
        $Unit1->loadResource(__FILE__);

        //Shows the form
        $Unit1->show();

?>
