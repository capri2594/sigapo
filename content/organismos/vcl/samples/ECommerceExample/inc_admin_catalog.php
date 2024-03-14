<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("dbctrls.inc.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminCatalog extends Page
        {
            public $Catalog = null;
            public $Label4 = null;
            public $Label1 = null;
            public $Label2 = null;
            public $Image1 = null;
            public $Msg = null;
            public $AddSubmitButton = null;
            public $AddImageInput = null;
            public $AddCostInput = null;
            public $AddNameInput = null;
            function AdminCatalogShow($sender, $params)
            {
                $page = $_REQUEST[ 'page' ];

                if( $page == 'add' )
                {
                    $prod_name = $this->AddNameInput->Text;
                    $prod_cost = $this->AddCostInput->Text;
                    $prod_image = $this->AddImageInput->Text;

                    if( empty( $prod_name ) || !strlen( $prod_cost ) )
                    {
                        $this->Msg->Value = "Can't add product. Product name or cost empty.";
                    }

                    $query = "INSERT INTO products (Name,Image,Price) VALUES('" . mysql_real_escape_string( $prod_name ) . "','" . mysql_real_escape_string( $prod_image ) . "','" . mysql_real_escape_string( $prod_cost ) . "')";

                    GetDBModule()->Query1->close();
                    GetDBModule()->Query1->LimitStart = '-1';
                    GetDBModule()->Query1->LimitCount = '-1';
                    GetDBModule()->Query1->SQL = $query;
                    GetDBModule()->Query1->open();
                    GetDBModule()->Query1->close();

                    $this->AddNameInput->Text = '';
                    $this->AddCostInput->Text = '';
                    $this->AddImageInput->Text = '';

                    GetDBModule()->Table1->close();
                    GetDBModule()->Table1->open();
                }
                else if( $page == 'delete' )
                {
                    $id = $_REQUEST[ 'id' ];

                    $query = "DELETE FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                    GetDBModule()->Query1->close();
                    GetDBModule()->Query1->LimitStart = '-1';
                    GetDBModule()->Query1->LimitCount = '-1';
                    GetDBModule()->Query1->SQL = $query;
                    GetDBModule()->Query1->open();
                    GetDBModule()->Query1->close();

                    GetDBModule()->Table1->close();
                    GetDBModule()->Table1->open();
                }

                $this->Catalog->DataSource = GetDBModule()->Datasource1;
            }


            function Label3BeforeShow($sender, $params)
            {
                $sender->Link = 'admin.php?page=delete&id=' . GetDBModule()->Table1->ID;
            }

            function Image1BeforeShow($sender, $params)
            {
                $sender->ImageSource = 'images/' . GetDBModule()->Table1->Image;
            }

            function Label2BeforeShow($sender, $params)
            {
                $sender->Caption = '$' . sprintf( "%01.2f", GetDBModule()->Table1->Price );
            }

            function Label1BeforeShow($sender, $params)
            {
                $sender->Caption = GetDBModule()->Table1->Name;
            }

        }

        global $application;

        global $AdminCatalog;

        //Creates the form
        $AdminCatalog=new AdminCatalog($application);

        //Read from resource file
        $AdminCatalog->loadResource(__FILE__);

        //Shows the form
        $AdminCatalog->show();

?>
