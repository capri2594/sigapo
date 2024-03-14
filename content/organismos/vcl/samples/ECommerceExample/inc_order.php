<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Order extends Page
        {
        public $Msg=null;
        
        function OrderCreate($sender, $params)
        {
            global $ECommerceMain;

            $items = explode( ',', $_COOKIE[ 'cart' ] );
            $subtotal = 0;

            foreach( $items as $data )
            {
                list( $id, $quantity ) = explode( '=', $data );

                if( empty( $id ) || substr( $id, 0, 1 ) == 'U' )
                    continue;

                GetDBModule()->Query1->close();

                GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                GetDBModule()->Query1->open();

                $subtotal += GetDBModule()->Query1->Price * $quantity;
            }

            GetDBModule()->Query1->close();

            $query = "SELECT * FROM users WHERE Username = '" . mysql_real_escape_string( $ECommerceMain->CurrentUserLogin->GetLoggedInUser() ) . "'";

            GetDBModule()->Query1->SQL = $query;
            GetDBModule()->Query1->open();

            $UserID = GetDBModule()->Query1->ID;

            GetDBModule()->Query1->close();

            $total = $subtotal;

            $query = "INSERT INTO orders (User,Date,Subtotal,Total) VALUES('" . $UserID . "','" . date( 'Y-m-d' ) . "','" . $subtotal . "','" . $total . "')";

            GetDBModule()->Query1->SQL = $query;
            GetDBModule()->Query1->open();
            GetDBModule()->Query1->close();

            $OrderID = GetDBModule()->Database1->_connection->Insert_ID( 'orders', 'ID' );

            foreach( $items as $data )
            {
                list( $id, $quantity ) = explode( '=', $data );

                if( empty( $id ) || substr( $id, 0, 1 ) == 'U' )
                    continue;

                GetDBModule()->Query1->close();
                GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";
                GetDBModule()->Query1->open();

                $amount = GetDBModule()->Query1->Price * $quantity;

                $query = "INSERT INTO orders_products (OrderID,ProductID,Quantity,Amount) VALUES('" . $OrderID . "','" . $id . "','" . $quantity . "','" . $amount . "')";

                GetDBModule()->Query1->close();
                GetDBModule()->Query1->SQL = $query;
                GetDBModule()->Query1->open();
                GetDBModule()->Query1->close();
            }

            setcookie( 'cart', '' );

            $this->Msg->Value = 'Your order has been successfully processed. Thank you for choosing us.';
        }

}

        global $application;

        global $Order;

        //Creates the form
        $Order=new Order($application);

        //Read from resource file
        $Order->loadResource(__FILE__);

        //Shows the form
        $Order->show();

?>
