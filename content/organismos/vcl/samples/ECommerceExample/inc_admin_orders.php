<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("dbctrls.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class AdminOrders extends Page
        {
            public $Orders = null;

            function AdminOrdersBeforeShow($sender, $params)
            {
                $str = '';

                for( GetDBModule()->Table2->first(); !GetDBModule()->Table2->EOF; GetDBModule()->Table2->next() )
                {
                    $row = '<tr>';
                    $row .= '<td>' . GetDBModule()->Table2->ID . '</td>';

                    $query = "SELECT * FROM users WHERE ID = '" . mysql_real_escape_string( GetDBModule()->Table2->User ) . "'";

                    GetDBModule()->Query1->close();
                    GetDBModule()->Query1->SQL = $query;
                    GetDBModule()->Query1->open();

                    $row .= '<td>' . GetDBModule()->Query1->Name . '</td>';

                    GetDBModule()->Query1->close();

                    $row .= '<td>' . GetDBModule()->Table2->Date . '</td>';
                    $row .= '<td>$' . GetDBModule()->Table2->Total . '</td>';
                    $row .= '<td><a href="admin.php?page=view&id=' . GetDBModule()->Table2->ID . '">View</a></td>';
                    $row .= '</tr>';

                    $str .= $row;
                }

                $this->Orders->Value = $str;
            }
        }

        global $application;

        global $AdminOrders;

        //Creates the form
        $AdminOrders=new AdminOrders($application);

        //Read from resource file
        $AdminOrders->loadResource(__FILE__);

        //Shows the form
        $AdminOrders->show();

?>
