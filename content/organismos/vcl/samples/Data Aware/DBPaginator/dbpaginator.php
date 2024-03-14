<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit1 extends Page
        {
               public $Label6 = null;
               public $Label4 = null;
               public $fdCUSTOMER5 = null;
               public $fdCUSTOMER4 = null;
               public $fdCUSTOMER3 = null;
               public $fdCUSTOMER2 = null;
               public $fdCUSTOMER1 = null;
               public $dsCUSTOMER1 = null;
               public $dbEMPLOYEE1 = null;
               public $tbCUSTOMER1 = null;
               public $Button1 = null;
               public $DBPaginator1 = null;
               public $Label5 = null;
               public $Label3 = null;
               public $Label2 = null;
               public $Label1 = null;
               function Button1Click($sender, $params)
               {
                        $this->dsCUSTOMER1->DataSet->post();
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
