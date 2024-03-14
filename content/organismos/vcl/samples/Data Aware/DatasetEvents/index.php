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
        class Unit201 extends Page
        {
               public $meLog = null;
               public $btnClose = null;
               public $btnOpen = null;
               public $ddproducts1 = null;
               public $dsproducts1 = null;
               public $dboscommerce1 = null;
               public $tbproducts1 = null;
               function tbproducts1DeleteError($sender, $params)
               {
                    $this->meLog->AddLine("DeleteError");
               }

               function tbproducts1BeforePost($sender, $params)
               {
                    $this->meLog->AddLine("BeforePost");
               

               }

               function tbproducts1BeforeOpen($sender, $params)
               {
                    $this->meLog->AddLine("BeforeOpen");
               

               }

               function tbproducts1BeforeInsert($sender, $params)
               {
                    $this->meLog->AddLine("BeforeInsert");
               

               }

               function tbproducts1BeforeEdit($sender, $params)
               {
                    $this->meLog->AddLine("BeforeEdit");
               

               }

               function tbproducts1BeforeDelete($sender, $params)
               {
                    $this->meLog->AddLine("BeforeDelete");
               

               }

               function tbproducts1BeforeClose($sender, $params)
               {
                    $this->meLog->AddLine("BeforeClose");
               

               }

               function tbproducts1BeforeCancel($sender, $params)
               {
                    $this->meLog->AddLine("BeforeCancel");
               

               }

               function tbproducts1AfterPost($sender, $params)
               {
                    $this->meLog->AddLine("AfterPost");
               

               }

               function tbproducts1AfterOpen($sender, $params)
               {
                    $this->meLog->AddLine("AfterOpen");
               

               }

               function tbproducts1AfterInsert($sender, $params)
               {
                    $this->meLog->AddLine("AfterInsert");
               

               }

               function tbproducts1AfterEdit($sender, $params)
               {
                    $this->meLog->AddLine("AfterEdit");
               

               }

               function tbproducts1AfterDelete($sender, $params)
               {
                    $this->meLog->AddLine("AfterDelete");
               

               }

               function tbproducts1AfterClose($sender, $params)
               {
                    $this->meLog->AddLine("AfterClose");               
               

               }

               function tbproducts1AfterCancel($sender, $params)
               {
                    $this->meLog->AddLine("AfterCancel");
               }

               function btnCloseClick($sender, $params)
               {
                    $this->meLog->AddLine("------------");
                    $this->meLog->AddLine("btnCloseClick");               
                $this->tbproducts1->Close();
               }

               function btnOpenClick($sender, $params)
               {
                    $this->meLog->AddLine("------------");
                    $this->meLog->AddLine("btnOpenClick");
                    $this->tbproducts1->Open();
               }

        }

        global $application;

        global $Unit201;

        //Creates the form
        $Unit201=new Unit201($application);

        //Read from resource file
        $Unit201->loadResource(__FILE__);

        //Shows the form
        $Unit201->show();

?>
