<?php
        //Includes
        require_once("vcl/vcl.inc.php");
        require_once("DbModule.php");
        use_unit("rawoutput.inc.php");
        use_unit("forms.inc.php");
        use_unit("extctrls.inc.php");
        use_unit("stdctrls.inc.php");

        //Class definition
        class Checkout extends Page
        {
        public $SubmitButton=null;
        public $Phone=null;
        public $Postcode=null;
        public $Country=null;
        public $State=null;
        public $City=null;
        public $Address=null;
        public $Name=null;
        public $Total=null;
        public $Subtotal=null;
        public $CartContents=null;
                public $Msg=null;
        

            protected $CartValue = '';

        
        function CheckoutBeforeShow($sender, $params)
        {
            global $ECommerceMain;

            $items = explode( ',', $this->CartValue );

            $str = '';
            $subtotal = 0;

            foreach( $items as $data )
            {
                list( $id, $quantity ) = explode( '=', $data );

                if( empty( $id ) || substr( $id, 0, 1 ) == 'U' )
                    continue;

                GetDBModule()->Query1->close();

                GetDBModule()->Query1->SQL = "SELECT * FROM products WHERE ID = '" . mysql_real_escape_string( $id ) . "'";

                GetDBModule()->Query1->open();

                $str .= '<tr>';
                $str .= '<td>' . GetDBModule()->Query1->Name . '</td>';
                $str .= '<td width="50">$' . sprintf( "%01.2f", GetDBModule()->Query1->Price * $quantity ) . '</td>';
                $str .= '<td width="50"><a href="index.php?page=delete&id=' . $id . '">Delete</a></td>';
                $str .= "</tr>\r\n";

                $subtotal += GetDBModule()->Query1->Price * $quantity;
            }

            $this->CartContents->Value = $str;

            $this->Subtotal->Value = '$' . sprintf( "%01.2f", $subtotal );
            $this->Total->Value = '$' . sprintf( "%01.2f", $subtotal );

            $query = "SELECT * FROM users WHERE Username = '" . mysql_real_escape_string( $ECommerceMain->CurrentUserLogin->GetLoggedInUser() ) . "'";

            GetDBModule()->Query1->close();

            GetDBModule()->Query1->SQL = $query;

            GetDBModule()->Query1->open();

            if( GetDBModule()->Query1->RecordCount > 0 )
            {
                $this->Name->Value = GetDBModule()->Query1->Name;
                $this->Address->Value = GetDBModule()->Query1->Address;
                $this->City->Value = GetDBModule()->Query1->City;
                $this->State->Value = GetDBModule()->Query1->State;
                $this->Country->Value = GetDBModule()->Query1->Country;
                $this->Postcode->Value = GetDBModule()->Query1->Postcode;
                $this->Phone->Value = GetDBModule()->Query1->Phone;
            }

            GetDBModule()->Query1->close();
        }

        function CheckoutCreate($sender, $params)
        {
            global $ECommerceMain;

            $this->CartValue = $_COOKIE[ 'cart' ];

            if( empty( $this->CartValue ) )
            {
                $this->TemplateFilename = 'templates/empty_cart.tpl';
                return;
            }

            if( $_REQUEST[ 'registered' ] == 1 )
            {
                $this->Msg->Value = 'You have successfully registered. Click Login below to sign in to your account to start the checkout process.';
            }

            if( $ECommerceMain->CurrentUserLogin->GetLoggedInUser() === false )
            {
                // User not logged in, so show the login/register page.
                $this->TemplateFilename = 'templates/login_register.tpl';
                return;
            }

            $this->TemplateFilename = 'templates/checkout.tpl';
        }

}

        global $application;

        global $Checkout;

        //Creates the form
        $Checkout=new Checkout($application);

        //Read from resource file
        $Checkout->loadResource(__FILE__);

        //Shows the form
        $Checkout->show();

?>
