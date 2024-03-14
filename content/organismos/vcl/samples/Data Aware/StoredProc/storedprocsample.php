<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("comctrls.inc.php");
        use_unit("dbgrids.inc.php");
        use_unit("db.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class StoredProcSample extends Page
        {
               public $Label1 = null;
               public $DBGrid2 = null;
               public $Datasource2 = null;
               public $StoredProc2 = null;
               public $tbcustomers = null;
               public $cbCustomers = null;
               public $StoredProc1 = null;
               public $dbemployee = null;
               public $Button1 = null;
               public $DBGrid1 = null;
               public $Datasource1 = null;
               public $Query1 = null;
               function cbCustomersBeforeShow($sender, $params)
               {
                    $items=array();
                    $this->tbcustomers->First();
                    while (!$this->tbcustomers->EOF)
                    {
                        $items[$this->tbcustomers->CUST_NO]=$this->tbcustomers->CUSTOMER;
                        $this->tbcustomers->Next();
                    }

                    $this->cbCustomers->Items=$items;
               }

               function Button1Click($sender, $params)
               {
                    $params=array();
                    $params[]=$this->cbCustomers->ItemIndex;
                    $this->StoredProc1->Params=$params;

                    //Prepare the stored proc
                    $this->StoredProc1->Prepare();

                    //Reopen the dataset
                    $this->StoredProc1->close();
                    $this->StoredProc1->open();
               }

        }

        global $application;

        global $StoredProcSample;

        //Creates the form
        $StoredProcSample=new StoredProcSample($application);

        //Read from resource file
        $StoredProcSample->loadResource(__FILE__);

        //Shows the form
        $StoredProcSample->show();

?>
