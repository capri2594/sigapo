<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("interbase.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit224 extends Page
        {
               public $IBStoredProc1 = null;
               public $DBGrid1 = null;
               public $Datasource1 = null;
               public $IBDatabase1 = null;
        }

        global $application;

        global $Unit224;

        //Creates the form
        $Unit224=new Unit224($application);

        //Read from resource file
        $Unit224->loadResource(__FILE__);

        //Shows the form
        $Unit224->show();

?>
