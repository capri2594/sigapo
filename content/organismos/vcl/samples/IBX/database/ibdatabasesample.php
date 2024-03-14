<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        use_unit("interbase.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Unit220 extends Page
        {
               public $Button1 = null;
               public $meLog = null;
               public $btnDisconnect = null;
               public $btnConnect = null;
               public $IBDatabase1 = null;
               function Button1Click($sender, $params)
               {
                $tables=$this->IBDatabase1->tables();
                $items=$this->meLog->Lines;
                $items=array_merge($items,$tables);
                $this->meLog->Lines=$items;
               }


               function btnDisconnectClick($sender, $params)
               {
                    $this->meLog->AddLine("btnDisconnectClick");
                    $this->IBDatabase1->Close();
               }

               function btnConnectClick($sender, $params)
               {
                    $this->meLog->AddLine("btnConnectClick");
                $this->IBDatabase1->Open();
               }

               function IBDatabase1BeforeDisconnect($sender, $params)
               {
                    $this->meLog->AddLine("BeforeDisconnect");
               }

               function IBDatabase1BeforeConnect($sender, $params)
               {
                    $this->meLog->AddLine("BeforeConnect");
               }

               function IBDatabase1AfterDisconnect($sender, $params)
               {
                    $this->meLog->AddLine("AfterDisconnect");
               }

               function IBDatabase1AfterConnect($sender, $params)
               {
                    $this->meLog->AddLine("AfterConnect");
               }

        }

        global $application;

        global $Unit220;

        //Creates the form
        $Unit220=new Unit220($application);

        //Read from resource file
        $Unit220->loadResource(__FILE__);

        //Shows the form
        $Unit220->show();

?>
