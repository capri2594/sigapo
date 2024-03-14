<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("dbtables.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class DBEventsSample extends Page
        {
               public $btnDisconnect = null;
               public $btnConnect = null;
               public $meLog = null;
               public $dboscommerce1 = null;
               function btnDisconnectClick($sender, $params)
               {
                    $this->meLog->AddLine("btnDisconnectClick");               
                    $this->dboscommerce1->Close();
               }

               function btnConnectClick($sender, $params)
               {
                    $this->meLog->AddLine("btnConnectClick");
                $this->dboscommerce1->Open();
               }

               function dboscommerce1BeforeDisconnect($sender, $params)
               {
                    $this->meLog->AddLine("BeforeDisconnect");
               }

               function dboscommerce1BeforeConnect($sender, $params)
               {
                    $this->meLog->AddLine("BeforeConnect");
               }

               function dboscommerce1AfterDisconnect($sender, $params)
               {
                    $this->meLog->AddLine("AfterDisconnect");
               }

               function dboscommerce1AfterConnect($sender, $params)
               {
                    $this->meLog->AddLine("AfterConnect");
               }

        }

        global $application;

        global $DBEventsSample;

        //Creates the form
        $DBEventsSample=new DBEventsSample($application);

        //Read from resource file
        $DBEventsSample->loadResource(__FILE__);

        //Shows the form
        $DBEventsSample->show();

?>
