<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("buttons.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AjaxDatabase extends Page
        {
               public $lbCurrently = null;
               public $ListBox1 = null;
               public $ddaddress_book1 = null;
               public $dsaddress_book1 = null;
               public $dboscommerce1 = null;
               public $tbaddress_book1 = null;
               function ListBox1JSChange($sender, $params)
               {               
               ?>
                    //Here extract the table we want to change the grid
                    params=document.AjaxDatabase.ListBox1.options[document.AjaxDatabase.ListBox1.value].text;
                    <?php
                        echo $this->ListBox1->ajaxCall("changeTable");
                    ?>

               <?php
               }

               //Method that will be called using ajax
               function ChangeTable($sender,$params)
               {
                    //Change the caption
                    $this->lbCurrently->Caption="Currently browsing $params";

                    //And tablename
                    $this->tbaddress_book1->TableName=$params;
                    $this->tbaddress_book1->Active=false;
                    $this->tbaddress_book1->Active=true;
               }

               function AjaxDatabaseBeforeShow($sender, $params)
               {
                    $tables=$this->dboscommerce1->tables();
                    $this->ListBox1->Items=$tables;
               }

        }

        global $application;

        global $AjaxDatabase;

        //Creates the form
        $AjaxDatabase=new AjaxDatabase($application);

        //Read from resource file
        $AjaxDatabase->loadResource(__FILE__);

        //Shows the form
        $AjaxDatabase->show();

?>
