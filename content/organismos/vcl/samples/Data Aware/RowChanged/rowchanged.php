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
        class Unit112 extends Page
        {
               public $Memo1 = null;
               public $ddPROJECT1 = null;
               public $dsPROJECT1 = null;
               public $dbEMPLOYEE1 = null;
               public $tbPROJECT1 = null;
               function ddPROJECT1JSRowChanged($sender, $params)
               {               
               ?>
               //Add your javascript code here
                     document.Unit112.Memo1.value=ddPROJECT1.getTableModel().getValue(2, ddPROJECT1.getFocusedRow());
               <?php
               }

        }

        global $application;

        global $Unit112;

        //Creates the form
        $Unit112=new Unit112($application);

        //Read from resource file
        $Unit112->loadResource(__FILE__);

        //Shows the form
        $Unit112->show();

?>
