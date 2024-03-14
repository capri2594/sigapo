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
        class QuerySample extends Page
        {
               public $dtEnd = null;
               public $Label2 = null;
               public $Label1 = null;
               public $dtInit = null;
               public $Button1 = null;
               public $DBGrid1 = null;
               public $Datasource1 = null;
               public $Query1 = null;
               public $dboscommerce1 = null;
               function Button1Click($sender, $params)
               {
                    //Setup a filter with Params
                    $this->Query1->Filter=" products_date_added>=".$this->dboscommerce1->Param('init')." and products_date_added<=".$this->dboscommerce1->Param('end')."";

                    //Setup the params array
                    $params=array();
                    $params[]=$this->dtInit->Text;
                    $params[]=$this->dtEnd->Text;
                    $this->Query1->Params=$params;

                    //Prepare the query
                    $this->Query1->Prepare();

                    //Reopen the dataset
                    $this->Query1->close();
                    $this->Query1->open();
               }

        }

        global $application;

        global $QuerySample;

        //Creates the form
        $QuerySample=new QuerySample($application);

        //Read from resource file
        $QuerySample->loadResource(__FILE__);

        //Shows the form
        $QuerySample->show();

?>
