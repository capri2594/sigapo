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
        class MasterDetail extends Page
        {
               public $ddproducts_description1 = null;
               public $dsproducts_description1 = null;
               public $tbproducts_description1 = null;
               public $ddproducts1 = null;
               public $dsproducts1 = null;
               public $dboscommerce1 = null;
               public $tbproducts1 = null;
               function ddproducts1JSRowChanged($sender, $params)
               {
               ?>
                     products_id=ddproducts1.getTableModel().getValue(0, ddproducts1.getFocusedRow());
                     params=products_id;
               <?php
                    echo $this->ddproducts1->ajaxCall("updateDetail");
               }

               function updateDetail($sender, $params)
               {
                    $this->tbproducts1->products_id=$params;
                    $this->tbproducts_description1->Refresh();
                    $this->tbproducts1->Cancel();
               }

        }

        global $application;

        global $MasterDetail;

        //Creates the form
        $MasterDetail=new MasterDetail($application);

        //Read from resource file
        $MasterDetail->loadResource(__FILE__);

        //Shows the form
        $MasterDetail->show();

?>
