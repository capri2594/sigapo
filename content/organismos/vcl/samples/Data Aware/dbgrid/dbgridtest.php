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
        class DBGridTest extends Page
        {
               public $meLog = null;
               public $ddproducts1 = null;
               public $dsproducts1 = null;
               public $dboscommerce1 = null;
               public $tbproducts1 = null;
               function ddproducts1JSRowSaved($sender, $params)
               {
               ?>
                document.DBGridTest.meLog.value+="row saved\n";
                if (event.ex == null)
                {
                        document.DBGridTest.meLog.value+="sucessful, result: "+event.result+"\n";
                }
                else
                {
                        document.DBGridTest.meLog.value+="error, result: "+event.ex+"\n";
                }
               <?php
               }

               function ddproducts1JSDataChanged($sender, $params)
               {
               ?>
                document.DBGridTest.meLog.value+="datachange\n";
               <?php
               }

        }

        global $application;

        global $DBGridTest;

        //Creates the form
        $DBGridTest=new DBGridTest($application);

        //Read from resource file
        $DBGridTest->loadResource(__FILE__);

        //Shows the form
        $DBGridTest->show();

?>
