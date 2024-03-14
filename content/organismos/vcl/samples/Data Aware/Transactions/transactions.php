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
        class TransactionsSample extends Page
        {
               public $btnCancel = null;
               public $btnSuccess = null;
               public $ddEMPLOYEE1 = null;
               public $dsEMPLOYEE1 = null;
               public $dbEMPLOYEE1 = null;
               public $tbEMPLOYEE1 = null;
               function btnCancelClick($sender, $params)
               {
                    $this->dbEMPLOYEE1->BeginTrans();
                    $this->tbEMPLOYEE1->Append();
                    $this->tbEMPLOYEE1->FIRST_NAME="TEST";
                    $this->tbEMPLOYEE1->LAST_NAME="TEST";
                    $this->tbEMPLOYEE1->DEPT_NO="600";
                    $this->tbEMPLOYEE1->JOB_CODE="VP";
                    $this->tbEMPLOYEE1->JOB_GRADE="2";
                    $this->tbEMPLOYEE1->JOB_COUNTRY="USA";
                    $this->tbEMPLOYEE1->SALARY="100000";
                    $this->tbEMPLOYEE1->Post();
                    $this->dbEMPLOYEE1->CompleteTrans(false);
                    $this->tbEMPLOYEE1->Refresh();
               }

               function btnSuccessClick($sender, $params)
               {
                    $this->dbEMPLOYEE1->BeginTrans();
                    $this->tbEMPLOYEE1->Append();
                    $this->tbEMPLOYEE1->FIRST_NAME="TEST";
                    $this->tbEMPLOYEE1->LAST_NAME="TEST";
                    $this->tbEMPLOYEE1->DEPT_NO="600";
                    $this->tbEMPLOYEE1->JOB_CODE="VP";
                    $this->tbEMPLOYEE1->JOB_GRADE="2";
                    $this->tbEMPLOYEE1->JOB_COUNTRY="USA";
                    $this->tbEMPLOYEE1->SALARY="100000";
                    $this->tbEMPLOYEE1->Post();
                    $this->tbEMPLOYEE1->Refresh();
                    $this->dbEMPLOYEE1->CompleteTrans();
               }

        }

        global $application;

        global $TransactionsSample;

        //Creates the form
        $TransactionsSample=new TransactionsSample($application);

        //Read from resource file
        $TransactionsSample->loadResource(__FILE__);

        //Shows the form
        $TransactionsSample->show();

?>
