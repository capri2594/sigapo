<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminView extends Page
        {
            public $Total = null;
            public $Subtotal = null;
            public $CartContents = null;
            public $Phone = null;
            public $Postcode = null;
            public $Country = null;
            public $State = null;
            public $City = null;
            public $Address = null;
            public $Name = null;
            public $ID = null;

            function AdminViewBeforeShow($sender, $params)
            {
                $id = $_REQUEST[ 'id' ];

                $this->ID->Value = $id;

                $query = "SELECT * FROM orders WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                GetDBModule()->Query1->close();
                GetDBModule()->Query1->SQL = $query;
                GetDBModule()->Query1->open();

                $userid = GetDBModule()->Query1->User;

                $this->Subtotal->Value = GetDBModule()->Query1->Subtotal;
                $this->Total->Value = GetDBModule()->Query1->Total;

                GetDBModule()->Query1->close();

                $query = "SELECT * FROM users WHERE ID = '" . mysql_real_escape_string( $userid ) . "'";

                GetDBModule()->Query1->SQL = $query;
                GetDBModule()->Query1->open();

                $this->Name->Value = GetDBModule()->Query1->Name;
                $this->Address->Value = GetDBModule()->Query1->Address;
                $this->City->Value = GetDBModule()->Query1->City;
                $this->State->Value = GetDBModule()->Query1->State;
                $this->Country->Value = GetDBModule()->Query1->Country;
                $this->Postcode->Value = GetDBModule()->Query1->Postcode;
                $this->Phone->Value = GetDBModule()->Query1->Phone;

                GetDBModule()->Query1->close();

                $query = "SELECT * FROM orders_products WHERE OrderID = '" . mysql_real_escape_string( $id ) . "'";

                GetDBModule()->Query1->SQL = $query;
                GetDBModule()->Query1->open();

                $products = array();

                for( GetDBModule()->Query1->first(); !GetDBModule()->Query1->EOF; GetDBModule()->Query1->next() )
                {
                    $row = array( GetDBModule()->Query1->ProductID, GetDBModule()->Query1->Quantity, GetDBModule()->Query1->Amount );

                    array_push( $products, $row );
                }

                GetDBModule()->Query1->close();

                $str = '';

                foreach( $products as $data )
                {
                    list( $id, $quantity, $amount ) = $data;

                    $query = "SELECT Name FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                    GetDBModule()->Query1->SQL = $query;
                    GetDBModule()->Query1->open();

                    $str .= '<tr>';
                    $str .= '<td>' . GetDBModule()->Query1->Name . '</td>';
                    $str .= '<td align="center">' . $quantity . '</td>';
                    $str .= '<td align="center">' . $amount . '</td>';
                    $str .= '</tr>';

                    GetDBModule()->Query1->close();
                }

                $this->CartContents->Value = $str;
            }
        }

        global $application;

        global $AdminView;

        //Creates the form
        $AdminView=new AdminView($application);

        //Read from resource file
        $AdminView->loadResource(__FILE__);

        //Shows the form
        $AdminView->show();

?>
